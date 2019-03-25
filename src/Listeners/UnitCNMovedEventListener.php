<?php

namespace Wiltechsteam\FoundationServiceSingle\Listeners;

use Wiltechsteam\FoundationServiceSingle\Cores\StaffCore;
use Wiltechsteam\FoundationServiceSingle\Cores\UnitCore;
use Wiltechsteam\FoundationServiceSingle\Events\UnitCNMovedEvent;

class UnitCNMovedEventListener
{
    protected $unitPath;
    protected $staffPath;
    public function __construct()
    {
        $this->unitPath = config('foundation.models_namespace').'\Unit';
        $this->staffPath = config('foundation.models_namespace').'\Staff';
    }

    public function handle(UnitCNMovedEvent $event)
    {

        $unitData = UnitCore::toCnMovedModel($event->data['message']['entity']);

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

        if($unitCNModel["type"] == 8)
        {
            $field = "company_id";
        }

        if($unitCNModel["type"] == 4)
        {
            $field = "department_id";
        }

        if($unitCNModel["type"] == 2)
        {
            $field = "group_id";
        }

        $staffModel->where($field,$unitCNModel['id'])->update(StaffCore::addStaffUnitName($unitCNModel));


    }
}
