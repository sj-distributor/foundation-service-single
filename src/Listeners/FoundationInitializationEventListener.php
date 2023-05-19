<?php
namespace Wiltechsteam\FoundationServiceSingle\Listeners;

use Illuminate\Support\Facades\DB;
use Wiltechsteam\FoundationServiceSingle\Cores\PositionCore;
use Wiltechsteam\FoundationServiceSingle\Cores\StaffCore;
use Wiltechsteam\FoundationServiceSingle\Cores\UnitCore;
use Wiltechsteam\FoundationServiceSingle\Events\FoundationInitializationEvent;

class FoundationInitializationEventListener
{
    protected $staffPath;

    protected $positionPath;

    protected $unitPath;

    public function __construct()
    {
        $this->staffPath = config('foundation.models_namespace').'\Staff';

        $this->positionPath = config('foundation.models_namespace').'\Position';

        $this->unitPath = config('foundation.models_namespace').'\Unit';
    }

    public function handle(FoundationInitializationEvent $event)
    {
        $staffModel = new $this->staffPath();

        $positionModel = new $this->positionPath();

        $unitModel = new $this->unitPath();

        DB::transaction(function () use ($staffModel,$positionModel,$unitModel,$event)
        {
            $cnPositions = PositionCore::createInitializeList($event->data['message']['cnPositions'],1);
            $usPositions = PositionCore::createInitializeList($event->data['message']['usPositions'],2);
            $cnUnits = UnitCore::createInitializeList($event->data['message']['cnUnits'],1);
            $usUnits = UnitCore::createInitializeList($event->data['message']['usUnits'],2);
            $cnStaffs = StaffCore::createInitializeListUnitAndPosition($event->data['message']['cnStaffs'],$cnUnits,$cnPositions,1);
            $usStaffs = StaffCore::createInitializeListUnitAndPosition($event->data['message']['usStaffs'],$usUnits,$usPositions,2);
            $positionModel::query()->delete();
            foreach ($cnPositions as $cnPosition)
            {
                $positionModel::insert($cnPosition);
            }

            foreach ($usPositions as $usPosition)
            {
                $positionModel::insert($usPosition);
            }

            $staffModel::query()->delete();
            foreach ($cnStaffs as $cnStaff)
            {
                $staffModel::insert($cnStaff);
            }

            foreach ($usStaffs as $usStaff)
            {
                $staffModel::insert($usStaff);
            }


            $unitModel::query()->delete();
            foreach ($cnUnits as $cnUnit)
            {
                $unitModel::insert($cnUnit);
            }

            foreach ($usUnits as $usUnit)
            {
                $unitModel::insert($usUnit);
            }
        });
    }
}
