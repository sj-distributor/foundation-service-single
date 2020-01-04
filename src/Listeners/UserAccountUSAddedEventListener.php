<?php

namespace Wiltechsteam\FoundationServiceSingle\Listeners;

use Wiltechsteam\FoundationServiceSingle\Cores\StaffCore;
use Wiltechsteam\FoundationServiceSingle\Events\UserAccountUSAddedEvent;

class UserAccountUSAddedEventListener
{
    protected $staffPath;

    public function __construct()
    {
        $this->staffPath = config('foundation.models_namespace').'\Staff';
    }

    public function handle(UserAccountUSAddedEvent $event)
    {
        $staffData = StaffCore::toUserUpdateModel($event->data['message']);

        $staffModel = new $this->staffPath();

        $staffModel = $staffModel->findOrFail($staffData['id']);

        $staffModel->fill($staffData);

        $staffModel->save();
    }
}
