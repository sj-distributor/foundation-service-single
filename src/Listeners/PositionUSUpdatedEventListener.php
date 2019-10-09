<?php

namespace Wiltechsteam\FoundationServiceSingle\Listeners;

use Wiltechsteam\FoundationServiceSingle\Cores\PositionCore;
use Wiltechsteam\FoundationServiceSingle\Events\PositionUSUpdatedEvent;

class PositionUSUpdatedEventListener
{
    protected $positionPath;

    protected $staffPath;

    public function __construct()
    {
        $this->positionPath = config('foundation.models_namespace').'\Position';

        $this->staffPath = config('foundation.models_namespace').'\Staff';

    }

    public function handle(PositionUSUpdatedEvent $event)
    {

        $positionData = PositionCore::toUsModel( $event->data['message']);

        $positionUSModel = new $this->positionPath();

        $positionUSModel = $positionUSModel->findOrFail($positionData['id']);

        $positionUSModel->fill($positionData);

        $positionUSModel->save();

        $staffModel = new $this->staffPath();

        $staffModel->where(config('foundation.staff.position_id'),$positionData['id'])->update([config('foundation.staff.position_name')  =>  $positionData["name"]]);

    }
}
