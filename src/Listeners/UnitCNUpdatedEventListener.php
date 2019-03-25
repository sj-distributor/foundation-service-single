<?php

namespace Wiltechsteam\FoundationServiceSingle\Listeners;

use Wiltechsteam\FoundationServiceSingle\Cores\StaffCore;
use Wiltechsteam\FoundationServiceSingle\Cores\UnitCore;
use Wiltechsteam\FoundationServiceSingle\Events\UnitCNUpdatedEvent;

class UnitCNUpdatedEventListener
{
    protected $staffPath;
    protected $unitPath;

    public function __construct()
    {
        $this->staffPath = config('foundation.models_namespace').'\Staff';

        $this->unitPath = config('foundation.models_namespace').'\Unit';
    }

    public function handle(UnitCNUpdatedEvent $event)
    {
        $unitData = UnitCore::toCnModel($event->data['message']['entity']);

        $unitCNModel = new $this->unitPath();

        $unitCNModel = $unitCNModel->findOrFail($unitData['id']);

        $unitCNModel->fill($unitData);

        $unitCNModel->save();

        if(isset($event->data['message']['childEntities']))
        {
            $childsUnitData = $event->data['message']['childEntities'];

            foreach ($childsUnitData as $childUnitData)
            {
                $childUnitData =  UnitCore::toCnChildModel($childUnitData);

                $unitCNModel = $unitCNModel->findOrFail($childUnitData['id']);

                $unitCNModel->fill($childUnitData);

                $unitCNModel->save();
            }
        }

        $staffModel = new $this->staffPath();

        $field = null;

        if($unitData["type"] == 8)
        {
            $field = "company_id";
        }

        if($unitData["type"] == 4)
        {
            $field = "department_id";
        }

        if($unitData["type"] == 2)
        {
            $field = "group_id";
        }

        $staffModel->where($field,$unitData['id'])->update(StaffCore::addStaffUnitName($unitData));

        $staffModel->where($field,$unitData['id'])->where("id","!=", $unitData["leader_id"])->update(["superior_id" =>  $unitData["leader_id"]]);

    }



}
