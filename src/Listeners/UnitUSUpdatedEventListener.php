<?php

namespace Wiltechsteam\FoundationServiceSingle\Listeners;

use Wiltechsteam\FoundationServiceSingle\Cores\UnitCore;
use Wiltechsteam\FoundationServiceSingle\Events\UnitUSUpdatedEvent;


class UnitUSUpdatedEventListener
{
    protected $unitPath;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->unitPath = config('foundation.models_namespace').'\Unit';
    }

    /**
     * Handle the event.
     *
     * @param  UnitUSUpdatedEvent  $event
     * @return void
     */
    public function handle(UnitUSUpdatedEvent $event)
    {
        $unitData = UnitCore::toUsModel($event->data['message']['Entity']);

        $unitModel = new $this->unitPath();

        $unitModel = $unitModel->findOrFail($unitData['id']);

        $unitModel->fill($unitData);

        $unitModel->save();
    }
}
