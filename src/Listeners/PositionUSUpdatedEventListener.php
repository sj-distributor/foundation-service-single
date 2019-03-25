<?php

namespace Wiltechsteam\FoundationServiceSingle\Listeners;

use Wiltechsteam\FoundationServiceSingle\Cores\PositionCore;
use Wiltechsteam\FoundationServiceSingle\Events\PositionUSUpdatedEvent;

class PositionUSUpdatedEventListener
{
    protected $positionPath;

    public function __construct()
    {
        $this->positionPath = config('foundation.models_namespace').'\Position';
    }

    public function handle(PositionUSUpdatedEvent $event)
    {

        $positionData = PositionCore::toUsModel( $event->data['message']);

        $positionUSModel = new $this->positionPath();

        $positionUSModel = $positionUSModel->findOrFail($positionData['id']);

        $positionUSModel->fill($positionData);

        $positionUSModel->save();
    }
}
