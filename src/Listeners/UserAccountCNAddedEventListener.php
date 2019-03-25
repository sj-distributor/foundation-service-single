<?php

namespace Wiltechsteam\FoundationServiceSingle\Listeners;

use Wiltechsteam\FoundationServiceSingle\Cores\StaffCore;
use Wiltechsteam\FoundationServiceSingle\Events\UserAccountCNAddedEvent;


class UserAccountCNAddedEventListener
{
    protected $staffPath;

    public function __construct()
    {
        $this->staffPath = config('foundation.models_namespace').'\Staff';
    }

    public function handle(UserAccountCNAddedEvent $event)
    {
        $staffData = StaffCore::toUserUpdateModel($event->data['message']);

        $staffModel = new $this->staffPath();

        $staffModel = $staffModel->findOrFail($staffData['id']);

        $staffModel->fill($staffData);

        $staffModel->save();
    }
}
