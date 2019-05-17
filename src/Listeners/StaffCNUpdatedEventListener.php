<?php

namespace Wiltechsteam\FoundationServiceSingle\Listeners;

use Wiltechsteam\FoundationServiceSingle\Cores\StaffCore;
use Wiltechsteam\FoundationServiceSingle\Events\StaffCNUpdatedEvent;



class StaffCNUpdatedEventListener
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

    public function handle(StaffCNUpdatedEvent $event)
    {
        // $cnStaffs = StaffCore::createInitializeListUnitAndPosition($event->data['message']['cnStaffs'],[],[],1);

        //dd($cnStaffs[1]);

        $staffData = StaffCore::toCnModel($event->data['message']);

        $unitModel = new $this->unitPath();

        $unitList = $unitModel->where("country_code",1)->get();

        if(count($unitList) > 0)
        {
            $staffData = StaffCore::addDepartmentNameAndGroupName($staffData,$unitList);
        }

        $positionModel = new $this->positionPath();

        $positionList = $positionModel->where("id",$staffData["position_id"])->get();

        if(!empty($positionList))
        {
            $staffData = StaffCore::addPositionName($staffData,$positionList);
        }

        $staffCNModel = new $this->staffPath();

        $staffCNModel = $staffCNModel->findOrFail($staffData['id']);

        $staffCNModel->fill($staffData);

        $staffCNModel->save();
    }
}
