<?php

namespace Wiltechsteam\FoundationServiceSingle\Listeners;

use Wiltechsteam\FoundationServiceSingle\Cores\PositionCore;
use Wiltechsteam\FoundationServiceSingle\Events\PositionCNUpdatedEvent;

class PositionCNUpdatedEventListener
{
    protected $positionPath;
    protected $staffPath;
    public function __construct()
    {
        $this->staffPath = config('foundation.models_namespace').'\Staff';
        $this->positionPath = config('foundation.models_namespace').'\Position';
    }

    public function handle(PositionCNUpdatedEvent $event)
    {
        $positionData = PositionCore::toCnModel($event->data['message']);

        $positionCNModel = new $this->positionPath();

        $positionCNModel = $positionCNModel->findOrFail($positionData['id']);

        $positionCNModel->fill($positionData);

        $positionCNModel->save();

        $staffModel = new $this->staffPath();

        $staffModel->where("position_id",$positionData['id'])->update(["position_name"  =>  $positionData["name"]]);
    }
}
