<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace Skinny\Error;

use Skinny\Utility\Hash;

class Debugger
{
    /**
     * A list of errors generated by the application.
     *
     * @var array
     */
    public $errors = [];

    /**
     * The current output format.
     *
     * @var string
     */
    protected $outputFormat = 'array';

    /**
     * Holds current output data when outputFormat is false.
     *
     * @var string
     */
    protected $data = [];

    /**
     * Returns a reference to the Debugger singleton object instance.
     *
     * @param string|null $class Class name.
     * @return object
     */
    public static function getInstance($class = null)
    {
        static $instance = [];
        //@codingStandardsIgnoreStart
        if (!empty($class)) {
            if (!$instance || strtolower($class) != strtolower(get_class($instance[0]))) {
                $instance[0] = new $class();
            }
        }
        //@codingStandardsIgnoreEnd
        if (!$instance) {
            $instance[0] = new Debugger();
        }

        return $instance[0];
    }

    /**
     * Outputs a stack trace based on the supplied options.
     *
     * ### Options
     *
     * - `depth` - The number of stack frames to return. Defaults to 999
     * - `format` - The format you want the return. Defaults to the currently selected format. If
     * format is 'array' or 'points' the return will be an array.
     * - `args` - Should arguments for functions be shown? If true, the arguments for each method call
     * will be displayed.
     * - `start` - The stack frame to start generating a trace from. Defaults to 0
     *
     * @param array $options Format for outputting stack trace.
     *
     * @return mixed Formatted stack trace.
     */
    public static function trace(array $options = [])
    {
        $self = Debugger::getInstance();
        $defaults = [
            'depth' => 999,
            'format' => $self->outputFormat,
            'args' => false,
            'start' => 0,
            'scope' => null,
            'exclude' => ['call_user_func_array', 'trigger_error']
        ];
        $options = Hash::merge($defaults, $options);
        $backtrace = debug_backtrace();
        $count = count($backtrace);
        $back = [];
        $_trace = [
            'line' => '??',
            'file' => '[internal]',
            'class' => null,
            'function' => '[main]'
        ];
        for ($i = $options['start']; $i < $count && $i < $options['depth']; $i++) {
            $trace = $backtrace[$i] + ['file' => '[internal]', 'line' => '??'];
            $signature = $reference = '[main]';

            if (isset($backtrace[$i + 1])) {
                $next = $backtrace[$i + 1] + $_trace;
                $signature = $reference = $next['function'];

                if (!empty($next['class'])) {
                    $signature = $next['class'] . '::' . $next['function'];
                    $reference = $signature . '(';

                    if ($options['args'] && isset($next['args'])) {
                        $args = [];

                        foreach ($next['args'] as $arg) {
                            $args[] = Debugger::exportVar($arg);
                        }

                        $reference .= implode(', ', $args);
                    }

                    $reference .= ')';
                }
            }

            if (in_array($signature, $options['exclude'])) {
                continue;
            }

            if ($options['format'] === 'points' && $trace['file'] !== '[internal]') {
                $back[] = ['file' => $trace['file'], 'line' => $trace['line']];
            } else {
                $back[] = $trace;
            }
        }

        if ($options['format'] === 'array' || $options['format'] === 'points') {
            return $back;
        }

        return implode("\n", $back);
    }

    /**
     * Converts a variable to a string for debug output.
     *
     * @param string $var Variable to convert
     * @param int $depth The depth to output to. Defaults to 3.
     *
     * @return string Variable as a formatted string.
     */
    public static function exportVar($var, $depth = 3)
    {
        return static::export($var, $depth, 0);
    }

    /**
     * Protected export function used to keep track of indentation and recursion.
     *
     * @param mixed $var The variable to dump.
     * @param int $depth The remaining depth.
     * @param int $indent The current indentation level.
     *
     * @return string The dumped variable.
     */
    protected static function export($var, $depth, $indent)
    {
        switch (static::getType($var)) {
            case 'boolean':
                return ($var) ? 'true' : 'false';
            case 'integer':
                return '(int) ' . $var;
            case 'float':
                return '(float) ' . $var;
            case 'string':
                if (trim($var) === '') {
                    return "''";
                }

                return "'" . $var . "'";
            case 'array':
                return static::arrayExport($var, $depth - 1, $indent + 1);
            case 'resource':
                return strtolower(gettype($var));
            case 'null':
                return 'null';
            case 'unknown':
                return 'unknown';
            default:
                return static::object($var, $depth - 1, $indent + 1);
        }
    }

    /**
     * Handles object to string conversion.
     *
     * @param string $var Object to convert
     * @param int $depth The current depth, used for tracking recursion.
     * @param int $indent The current indentation level.
     *
     * @return string
     */
    protected static function object($var, $depth, $indent)
    {
        $out = '';
        $props = [];

        $className = get_class($var);
        $out .= 'object(' . $className . ') {';
        $break = "\n" . str_repeat("\t", $indent);
        $end = "\n" . str_repeat("\t", $indent - 1);

        if ($depth > 0 && method_exists($var, '__debugInfo')) {
            try {
                return $out . "\n" .
                substr(static::arrayExport($var->__debugInfo(), $depth - 1, $indent), 1, -1) .
                $end . '}';
            } catch (Exception $e) {
                return $out . "\n(unable to export object)\n }";
            }
        }

        if ($depth > 0) {
            $objectVars = get_object_vars($var);
            foreach ($objectVars as $key => $value) {
                $value = static::export($value, $depth - 1, $indent);
                $props[] = "$key => " . $value;
            }

            $ref = new \ReflectionObject($var);

            $filters = [
                \ReflectionProperty::IS_PROTECTED => 'protected',
                \ReflectionProperty::IS_PRIVATE => 'private',
            ];

            foreach ($filters as $filter => $visibility) {
                $reflectionProperties = $ref->getProperties($filter);

                foreach ($reflectionProperties as $reflectionProperty) {
                    $reflectionProperty->setAccessible(true);
                    $property = $reflectionProperty->getValue($var);
                    $value = static::export($property, $depth - 1, $indent);
                    $key = $reflectionProperty->name;
                    $props[] = sprintf('[%s] %s => %s', $visibility, $key, $value);
                }
            }

            $out .= $break . implode($break, $props) . $end;
        }
        $out .= '}';

        return $out;
    }

    /**
     * Export an array type object. Filters out keys used in datasource configuration.
     *
     * @param array $var The array to export.
     * @param int $depth The current depth, used for recursion tracking.
     * @param int $indent The current indentation level.
     *
     * @return string Exported array.
     */
    protected static function arrayExport(array $var, $depth, $indent)
    {
        $out = "[";
        $break = $end = null;
        if (!empty($var)) {
            $break = "\n" . str_repeat("\t", $indent);
            $end = "\n" . str_repeat("\t", $indent - 1);
        }
        $vars = [];
        if ($depth >= 0) {
            foreach ($var as $key => $val) {
                // Sniff for globals as !== explodes in < 5.4
                if ($key === 'GLOBALS' && is_array($val) && isset($val['GLOBALS'])) {
                    $val = '[recursion]';
                } elseif ($val !== $var) {
                    $val = static::export($val, $depth, $indent);
                }
                $vars[] = $break . static::exportVar($key) .
                ' => ' .
                $val;
            }
        } else {
            $vars[] = $break . '[maximum depth reached]';
        }

        return $out . implode(',', $vars) . $end . ']';
    }

    /**
     * Get the type of the given variable. Will return the class name
     * for objects.
     *
     * @param mixed $var The variable to get the type of.
     *
     * @return string The type of variable.
     */
    public static function getType($var)
    {
        if (is_object($var)) {
            return get_class($var);
        }
        if ($var === null) {
            return 'null';
        }
        if (is_string($var)) {
            return 'string';
        }
        if (is_array($var)) {
            return 'array';
        }
        if (is_int($var)) {
            return 'integer';
        }
        if (is_bool($var)) {
            return 'boolean';
        }
        if (is_float($var)) {
            return 'float';
        }
        if (is_resource($var)) {
            return 'resource';
        }

        return 'unknown';
    }
}