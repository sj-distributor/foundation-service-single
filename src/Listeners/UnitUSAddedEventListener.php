<?php

namespace Wiltechsteam\FoundationServiceSingle\Listeners;

use Wiltechsteam\FoundationServiceSingle\Cores\UnitCore;
use Wiltechsteam\FoundationServiceSingle\Events\UnitUSAddedEvent;


class UnitUSAddedEventListener
{
    protected $unitPath;

    public function __construct()
    {
        $this->unitPath = config('foundation.models_namespace').'\Unit';
    }

    public function handle(UnitUSAddedEvent $event)
    {
        $unitUSModel = new $this->unitPath();

        $unitUSModel::insert( UnitCore::toUsModel($event->data['message']));
        //$unitUSModel->save();
    }
}
