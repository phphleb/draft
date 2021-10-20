<?php
// php console drafts/generating-task --update-all
return [
    // php console drafts/generating-task MainDateSingleton
    'MainDateSingleton' => [
        'Singleton' => [
            'ObjectType' => '\DateTimeInterface',
            'ObjectName' => '\DateTime',
            'Value' => '\'now\'',
            'Description' => 'Demo singleton variant 1'
        ]
    ],
    // php console drafts/generating-task MainExceptionSingleton
    'MainExceptionSingleton' => [
        'Singleton' => [
            'ObjectType' => '\Throwable',
            'ObjectName' => '\Exception',
            'Value' => '\'Main Exception text\'',
            'Description' => 'Demo singleton variant 2'
        ]
    ],
    // php console drafts/generating-task Complex\MainFactory
    'Complex\MainFactory' => [
        'Complex\Factory' => [
            'ObjectInterface' => '\DraftDummy\StandardObjectInterface',
            'DynamicObjectInterface' => '\DraftDummy\DynamicObjectInterface',
            'InitObjectName' => '\DraftDummy\StandardObject',
            'ObjectName' => '$object',
            'Description' => 'Factory Method demo'
        ]
    ],
    // php console drafts/generating-task Complex\MainBuilder
    'Complex\MainBuilder' => [
        'Complex\Builder' => [
            'ObjectName' => '\DraftDummy\StandardObject',
            'Value' => 'NULL',
            'IsUnique' => 'FALSE',
            'Description' => 'Builder demo'
        ]
    ],
    // php console drafts/generating-task Complex\MainAdapter
    'Complex\MainAdapter' => [
        'Complex\Adapter' => [
            'DynamicObjectInterface' => '\DraftDummy\DynamicObjectInterface',
            'ObjectInterface' => '\DraftDummy\StandardObjectInterface',
            'ObjectName' => '$object',
            'MethodPrefix' => '',
            'OriginList' => '[\'getClassName\',\'getObject\']',
            'TargetList' => '[\'getClassName\',\'getDynamicObject\']',
            'Description' => 'Adapter demo'
        ]
    ]
];

