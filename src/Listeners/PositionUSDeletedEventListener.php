<?php

namespace Wiltechsteam\FoundationServiceSingle\Listeners;

use Wiltechsteam\FoundationServiceSingle\Events\PositionUSDeletedEvent;

class PositionUSDeletedEventListener
{
    protected $positionPath;

    public function __construct()
    {
        $this->positionPath = config('foundation.models_namespace').'\Position';
    }


    public function handle(PositionUSDeletedEvent $event)
    {

        $positionUSModel = new $this->positionPath();

        $positionUSModel::where('id', '=', $event->data['message']['PositionID'])->delete();
    }
}
