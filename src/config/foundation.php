<?php

return [
    /*队列配置*/
    'rabbitmq_queue' => env('RABBITMQ_QUEUE', ''),
    'rabbitmq_queue_error' => env('RABBITMQ_QUEUE_ERROR', ''),
    'rabbitmq_host' => env('RABBITMQ_HOST', '127.0.0.1'),
    'rabbitmq_port' => env('RABBITMQ_PORT', '5672'),
    'rabbitmq_vhost' => env('RABBITMQ_VHOST', '/'),
    'rabbitmq_login' => env('RABBITMQ_LOGIN', 'guest'),
    'rabbitmq_password' => env('RABBITMQ_PASSWORD','guest'),
    "models_namespace"  =>  "Wiltechsteam\FoundationServiceSingle",
    "events"    =>  [
        "FoundationInitializationEvent" =>   Wiltechsteam\FoundationServiceSingle\Events\FoundationInitializationEvent::class,
        "StaffCNAddedEvent"   =>  Wiltechsteam\FoundationServiceSingle\Events\StaffCNAddedEvent::class,
        "StaffCNUpdatedEvent"   =>  Wiltechsteam\FoundationServiceSingle\Events\StaffCNUpdatedEvent::class,
        "UserAccountCNAddedEvent"   =>  Wiltechsteam\FoundationServiceSingle\Events\UserAccountCNAddedEvent::class,
        "PositionCNAddedEvent"      =>   Wiltechsteam\FoundationServiceSingle\Events\PositionCNAddedEvent::class,
        "PositionCNDeletedEvent"  =>  Wiltechsteam\FoundationServiceSingle\Events\PositionCNDeletedEvent::class,
        "PositionCNUpdatedEvent"  =>  Wiltechsteam\FoundationServiceSingle\Events\PositionCNUpdatedEvent::class,
        "UnitCNAddedEvent"  =>  Wiltechsteam\FoundationServiceSingle\Events\UnitCNAddedEvent::class,
        "UnitCNDeletedEvent"  =>  Wiltechsteam\FoundationServiceSingle\Events\UnitCNDeletedEvent::class ,
        "UnitCNUpdatedEvent"  => Wiltechsteam\FoundationServiceSingle\Events\UnitCNUpdatedEvent::class ,
        "UnitCNMovedEvent"  => Wiltechsteam\FoundationServiceSingle\Events\UnitCNMovedEvent::class ,
        "StaffUSAddedEvent"  => Wiltechsteam\FoundationServiceSingle\Events\StaffUSAddedEvent::class ,
        "StaffUSUpdatedEvent"  => Wiltechsteam\FoundationServiceSingle\Events\StaffUSUpdatedEvent::class ,
        "PositionUSAddedEvent"  => Wiltechsteam\FoundationServiceSingle\Events\PositionUSAddedEvent::class ,
        "PositionUSDeletedEvent"  => Wiltechsteam\FoundationServiceSingle\Events\PositionUSDeletedEvent::class ,
        "PositionUSUpdatedEvent"  => Wiltechsteam\FoundationServiceSingle\Events\PositionUSUpdatedEvent::class  ,
        "UnitUSAddedEvent"  => Wiltechsteam\FoundationServiceSingle\Events\UnitUSAddedEvent::class ,
        "UnitUSUpdatedEvent"  => Wiltechsteam\FoundationServiceSingle\Events\UnitUSUpdatedEvent::class
    ],
    "listens"   =>
    [
        // Foundation Init
        Wiltechsteam\FoundationServiceSingle\Events\FoundationInitializationEvent::class =>
        [
            Wiltechsteam\FoundationServiceSingle\Listeners\FoundationInitializationEventListener::class,
        ],

        // CN Staff
        Wiltechsteam\FoundationServiceSingle\Events\StaffCNAddedEvent::class =>
        [
            Wiltechsteam\FoundationServiceSingle\Listeners\StaffCNAddedEventListener::class,
        ],
        Wiltechsteam\FoundationServiceSingle\Events\StaffCNUpdatedEvent::class =>
            [
                Wiltechsteam\FoundationServiceSingle\Listeners\StaffCNUpdatedEventListener::class,
            ],
        Wiltechsteam\FoundationServiceSingle\Events\UserAccountCNAddedEvent::class =>
            [
                Wiltechsteam\FoundationServiceSingle\Listeners\UserAccountCNAddedEventListener::class,
            ],

        // CN Position
        Wiltechsteam\FoundationServiceSingle\Events\PositionCNAddedEvent::class =>
            [
                Wiltechsteam\FoundationServiceSingle\Listeners\PositionCNAddedEventListener::class,
            ],
        Wiltechsteam\FoundationServiceSingle\Events\PositionCNDeletedEvent::class =>
            [
                Wiltechsteam\FoundationServiceSingle\Listeners\PositionCNDeletedEventListener::class,
            ],
        Wiltechsteam\FoundationServiceSingle\Events\PositionCNUpdatedEvent::class =>
            [
                Wiltechsteam\FoundationServiceSingle\Listeners\PositionCNUpdatedEventListener::class,
            ],

        // CN Unit
        Wiltechsteam\FoundationServiceSingle\Events\UnitCNAddedEvent::class =>
            [
                Wiltechsteam\FoundationServiceSingle\Listeners\UnitCNAddedEventListener::class,
            ],
        Wiltechsteam\FoundationServiceSingle\Events\UnitCNDeletedEvent::class =>
            [
                Wiltechsteam\FoundationServiceSingle\Listeners\UnitCNDeletedEventListener::class,
            ],
        Wiltechsteam\FoundationServiceSingle\Events\UnitCNUpdatedEvent::class =>
            [
                Wiltechsteam\FoundationServiceSingle\Listeners\UnitCNUpdatedEventListener::class,
            ],
        Wiltechsteam\FoundationServiceSingle\Events\UnitCNMovedEvent::class =>
            [
                Wiltechsteam\FoundationServiceSingle\Listeners\UnitCNMovedEventListener::class,
            ],

        // US Staff
        Wiltechsteam\FoundationServiceSingle\Events\StaffUSAddedEvent::class =>
            [
                Wiltechsteam\FoundationServiceSingle\Listeners\StaffUSAddedEventListener::class,
            ],

        Wiltechsteam\FoundationServiceSingle\Events\StaffUSUpdatedEvent::class =>
            [
                Wiltechsteam\FoundationServiceSingle\Listeners\StaffUSUpdatedEventListener::class,
            ],

        // US Position
        Wiltechsteam\FoundationServiceSingle\Events\PositionUSAddedEvent::class =>
            [
                Wiltechsteam\FoundationServiceSingle\Listeners\PositionUSAddedEventListener::class,
            ],
        Wiltechsteam\FoundationServiceSingle\Events\PositionUSDeletedEvent::class =>
            [
                Wiltechsteam\FoundationServiceSingle\Listeners\PositionUSDeletedEventListener::class,
            ],
        Wiltechsteam\FoundationServiceSingle\Events\PositionUSUpdatedEvent::class =>
            [
                Wiltechsteam\FoundationServiceSingle\Listeners\PositionUSUpdatedEventListener::class,
            ],

        // US Unit
        Wiltechsteam\FoundationServiceSingle\Events\UnitUSAddedEvent::class =>
            [
                Wiltechsteam\FoundationServiceSingle\Listeners\UnitUSAddedEventListener::class,
            ],
        Wiltechsteam\FoundationServiceSingle\Events\UnitUSUpdatedEvent::class =>
            [
                Wiltechsteam\FoundationServiceSingle\Listeners\UnitUSUpdatedEventListener::class,
            ],
    ]
];