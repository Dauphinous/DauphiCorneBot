<?php
return [
/**
 * Debug Level:
 *
 * Production Mode:
 * false: No error messages, errors, or warnings shown.
 *
 * Development Mode:
 * true: Errors and warnings shown.
 */
    'debug' => true,

/**
 * Configure basic information about the application.
 *
 * - namespace - The namespace to find app classes under.
 */
    'App' => [
        'namespace' => 'Bot',
        'paths' => [
            'plugins' => [ROOT . DS . 'plugins' . DS]
        ]
    ],

/**
 * Configure the Discord class.
 *
 * More informations can be found there :
 * https://discordphp.readme.io/docs/options
 *
 * - token - The Discord authentication token.
 * - shardID - The ID of the shard (if you are using sharding).
 * - shardCount - How many shards you are using (if you are using sharding).
 * - loop - The ReactPHP event loop.
 * - logger - The Monolog logger to use.
 * - loggerLevel - The logger level to use.
 * - logging - Whether logging is enabled.
 * - cachePool - The cache pool to use.
 * - loadAllMembers - Whether all members should be preloaded.
 * - disabledEvents - An array of events that will be ignored.
 * - pmChannels - Whether private message channels should be parsed and stored.
 * - storeMessages - Whether messages received should be stored.
 */
    'Discord' => [
        'token' => 'NDQ5NTc5MDE1NjQxMjM1NDU3.DiT0BA.A8-YKqkzJewzoioV1MXotYxfLdM',
        'logging' => true,
        'pmChannels' => true,
    ],

/**
 * Configure basic information about the bot.
 *
 * - admins : The list of bot's administrators. (IDs only)
 * - chatChannels : Restrict the bot to only listen to certain text channels. (IDs only)
 * - voiceChannel : Join a voice channel on startup. (IDs only)
 */
    'Bot' => [
        'admins' => [],
        'chatChannels' => [],
        'voiceChannel' => ''
    ],

/**
 * Configure Module manager.
 *
 * - priority - All modules that need to be loaded before others.
 */
    'Modules' => [
        'priority' => []
    ],

/**
 * Configure basic information about the the commands.
 *
 * - prefix - Prefix used with command.
 */
    'Command' => [
        'prefix' => '!'
    ]
];
