<?php

namespace Wiltechsteam\FoundationServiceSingle\Listeners;

use Wiltechsteam\FoundationServiceSingle\Cores\StaffCore;
use Wiltechsteam\FoundationServiceSingle\Events\StaffUSUpdatedEvent;

class StaffUSUpdatedEventListener
{
    protected $staffPath;

    public function __construct()
    {
        $this->staffPath = config('foundation.models_namespace').'\Staff';
    }

    public function handle(StaffUSUpdatedEvent $event)
    {

        $staffData = StaffCore::toUsModel ($event->data['message']);

        $staffUSModel = new $this->staffPath();

        $staffUSModel = $staffUSModel->findOrFail($staffData['id']);

        $staffUSModel->fill($staffData);

        $staffUSModel->save();
    }
}
