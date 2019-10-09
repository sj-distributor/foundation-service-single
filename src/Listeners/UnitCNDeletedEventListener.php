<?php

namespace Wiltechsteam\FoundationServiceSingle\Listeners;

use Wiltechsteam\FoundationServiceSingle\Events\UnitCNDeletedEvent;

class UnitCNDeletedEventListener
{
    protected $unitPath;

    public function __construct()
    {
        $this->unitPath = config('foundation.models_namespace').'\Unit';
    }

    public function handle(UnitCNDeletedEvent $event)
    {
        $unitCNModel = new $this->unitPath();

        $unitCNModel::where(config('foundation.unit.id'), '=', $event->data['message']['unitID'])->delete();
    }
}
