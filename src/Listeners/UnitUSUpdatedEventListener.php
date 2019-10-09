<?php

namespace Wiltechsteam\FoundationServiceSingle\Listeners;

use Wiltechsteam\FoundationServiceSingle\Cores\UnitCore;
use Wiltechsteam\FoundationServiceSingle\Events\UnitUSUpdatedEvent;
use Wiltechsteam\FoundationServiceSingle\Cores\StaffCore;


class UnitUSUpdatedEventListener
{
    protected $unitPath;

    protected $staffPath;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->unitPath = config('foundation.models_namespace').'\Unit';

        $this->staffPath = config('foundation.models_namespace').'\Staff';
    }

    /**
     * Handle the event.
     *
     * @param  UnitUSUpdatedEvent  $event
     * @return void
     */
    public function handle(UnitUSUpdatedEvent $event)
    {
        $unitData = UnitCore::toUsModel($event->data['message']['Entity']);

        $unitModel = new $this->unitPath();

        $unitModel = $unitModel->findOrFail($unitData['id']);

        $unitModel->fill($unitData);

        $unitModel->save();

        if(isset($event->data['message']['childEntities']))
        {
            $childsUnitData = $event->data['message']['childEntities'];

            foreach ($childsUnitData as $childUnitData)
            {
                $childUnitData =  UnitCore::toCnChildModel($childUnitData);

                $unitModel = $unitModel->findOrFail($childUnitData['id']);

                $unitModel->fill($childUnitData);

                $unitModel->save();
            }
        }

        $staffModel = new $this->staffPath();

        $field = null;

        

        if($unitData[config('foundation.unit.type')] == 8)
        {
            $field = "company_id";
        }

        if($unitData[config('foundation.unit.type')] == 4)
        {
            $field = "department_id";
        }

        if($unitData[config('foundation.unit.type')] == 2)
        {
            $field = "group_id";
        }

        $staffModel->where($field,$unitData['id'])->update(StaffCore::addStaffUnitName($unitData));

        $staffModel->where($field,$unitData['id'])->where("id","!=", $unitData[config('foundation.unit.leader_id')])->update([config('foundation.staff.superior_id') =>  $unitData[config('foundation.unit.leader_id')]]);

    }
}
