<?php
use Skinny\Core\Configure;

/**
 * Load the commands file configuration to register the commands.
 */
try {
    Configure::load('Basic.commands');
} catch (\Exception $e) {
    die($e->getMessage() . "\n");
}
