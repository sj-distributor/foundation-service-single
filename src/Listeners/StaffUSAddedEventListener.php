<?php

namespace Wiltechsteam\FoundationServiceSingle\Listeners;

use Wiltechsteam\FoundationServiceSingle\Cores\StaffCore;
use Wiltechsteam\FoundationServiceSingle\Events\StaffUSAddedEvent;

class StaffUSAddedEventListener
{
    protected $staffPath;

    protected $unitPath;

    protected $positionPath;

    public function __construct()
    {
        $this->staffPath = config('foundation.models_namespace').'\Staff';

        $this->unitPath = config('foundation.models_namespace').'\Unit';

        $this->positionPath = config('foundation.models_namespace').'\Position';
    }

    public function handle(StaffUSAddedEvent $event)
    {

        $staffData = StaffCore::toUsModel($event->data['message']);

        $unitModel = new $this->unitPath();

        $unitList = $unitModel->where(config('foundation.unit.country_code'), 2)->get();

        if (count($unitList) > 0) {
            $unitMapping = StaffCore::generateUnitMapping($unitList);
            $staffData = StaffCore::addDepartmentNameAndGroupName($staffData, $unitMapping);
            $staffData = StaffCore::addCompanyName($staffData, $unitMapping);
        }

        $positionModel = new $this->positionPath();

        $positionList = $positionModel->where(config('foundation.position.id'),$staffData[config('foundation.staff.position_id')])->get();

        if (!empty($positionList)) {
            $positionMapping = StaffCore::generatePositionMapping($positionList);
            $staffData = StaffCore::addPositionName($staffData, $positionMapping);
        }

        $staffUSModel = new $this->staffPath();

        $staffUSModel::insert($staffData);

    }
}
