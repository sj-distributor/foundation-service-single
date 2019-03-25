<?php

namespace Wiltechsteam\FoundationServiceSingle\Listeners;

use Wiltechsteam\FoundationServiceSingle\Cores\StaffCore;
use Wiltechsteam\FoundationServiceSingle\Events\StaffUSAddedEvent;

class StaffUSAddedEventListener
{
    protected $staffPath;

    public function __construct()
    {
        $this->staffPath = config('foundation.models_namespace').'\Staff';
    }

    public function handle(StaffUSAddedEvent $event)
    {
        $staffUSModel = new $this->staffPath();

        $staffUSModel::insert(StaffCore::toUsModel($event->data['message']));
       // $staffUSModel->save();
    }
}
