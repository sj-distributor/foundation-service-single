<?php

namespace Wiltechsteam\FoundationServiceSingle\Listeners;

use Wiltechsteam\FoundationServiceSingle\Cores\PositionCore;
use Wiltechsteam\FoundationServiceSingle\Events\PositionCNAddedEvent;


class PositionCNAddedEventListener
{
    protected $positionPath;

    public function __construct()
    {
        $this->positionPath = config('foundation.models_namespace').'\Position';
    }

    public function handle(PositionCNAddedEvent $event)
    {
        $positionCNModel = new $this->positionPath();

        $positionCNModel::insert(PositionCore::toCnModel($event->data['message']));
        //$positionCNModel->save();
    }
}
