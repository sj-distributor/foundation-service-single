<?php

namespace Wiltechsteam\FoundationServiceSingle\Listeners;

use Wiltechsteam\FoundationServiceSingle\Cores\UnitCore;
use Wiltechsteam\FoundationServiceSingle\Events\UnitCNAddedEvent;


class UnitCNAddedEventListener
{
    protected $unitPath;

    public function __construct()
    {
        $this->unitPath = config('foundation.models_namespace').'\Unit';
    }

    public function handle(UnitCNAddedEvent $event)
    {
        $unitCNModel = new $this->unitPath();


        $unitCNModel::insert(UnitCore::toCnModel($event->data['message']));
        //$unitCNModel->save();
    }
}
