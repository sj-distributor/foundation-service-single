<?php

namespace Wiltechsteam\FoundationServiceSingle\Listeners;

use Wiltechsteam\FoundationServiceSingle\Cores\PositionCore;
use Wiltechsteam\FoundationServiceSingle\Events\PositionUSAddedEvent;

class PositionUSAddedEventListener
{
    protected $positionPath;

    public function __construct()
    {
        $this->positionPath = config('foundation.models_namespace').'\Position';
    }

    public function handle(PositionUSAddedEvent $event)
    {
        $positionUSModel = new $this->positionPath();

        $positionUSModel::insert(PositionCore::toUsModel( $event->data['message']));
        //$positionUSModel->save();
    }
}
