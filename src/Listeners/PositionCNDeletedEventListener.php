<?php

namespace Wiltechsteam\FoundationServiceSingle\Listeners;

use Wiltechsteam\FoundationServiceSingle\Events\PositionCNDeletedEvent;

class PositionCNDeletedEventListener
{
    protected $positionPath;

    public function __construct()
    {
        $this->positionPath = config('foundation.models_namespace').'\Position';
    }

    public function handle(PositionCNDeletedEvent $event)
    {
        $positionCNModel = new $this->positionPath();

        $positionCNModel::where('id', '=',  $event->data['message']['positionID'])->delete();
    }
}
