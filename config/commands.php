<?php
/**
 * Configuration :
 *
 * 'params' : The number of required parameters that the command use.
 * 'syntax' : The syntax of command, used to the user how to use this command.
 * 'admin' (optional) (Default : false) : Define if it's an admin command.
 *
 */
return [
    'Commands' => [
        'pika' => [
            'params' => 1,
            'syntax' => 'pika [Message]'
        ],
        'rps' => [
            'params' => 2,
            'syntax' => 'rps [pierre|papier|ciseaux] [Nombre de DauphiCoins]'
        ],
        'pf' => [
            'params' => 2,
            'syntax' => 'pf [pile|face] [Nombre de DauphiCoins]'
        ]
    ]
];
