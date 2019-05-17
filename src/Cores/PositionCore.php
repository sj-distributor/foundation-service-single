<?php
/**
 * Created by PhpStorm.
 * User: ben
 * Date: 2018/8/3
 * Time: 0:16
 */

namespace Wiltechsteam\FoundationServiceSingle\Cores;

class PositionCore
{
    public static function createInitializeList($positionList,$countryCode)
    {
        $positionData  =  array();

        foreach ($positionList as $position)
        {
            $positionData[] = $countryCode == 1 ?
                self::toCnInitializeModel($position) :
                self::toUsInitializeModel($position);
        }

        return $positionData;
    }


    public static function toCnModel($foundationData)
    {
        $dataOut = [
            config('foundation.position.id')                    =>      strtoupper(@$foundationData['positionID']),
            config('foundation.position.unit_id')               =>      strtoupper(@$foundationData['unitID']),
            config('foundation.position.created_date')          =>      @$foundationData['createdDate'],
            config('foundation.position.created_by')            =>      @$foundationData['createdBy'],
            config('foundation.position.last_modified_date')    =>      isset($foundationData['lastModifiedDate'])?date("Y-m-d H:i:s",strtotime(@$foundationData["lastModifiedDate"])):null,
            config('foundation.position.last_modified_by')      =>      isset($foundationData['lastModifiedBy'])?$foundationData['lastModifiedBy']:null,
            config('foundation.position.name')                  =>      @$foundationData['name'],
            config('foundation.position.description')           =>      @$foundationData['description'],
            config('foundation.position.is_active')             =>      empty($foundationData['isActive'])?0:$foundationData['isActive'],
            config('foundation.position.country_code')          =>      1
        ];

        unset($dataOut['']);

        return $dataOut;
    }

    public static function toUsModel($foundationData)
    {
        $dataOut = [
            config('foundation.position.id')                    =>      strtoupper(@$foundationData['PositionID']),
            config('foundation.position.unit_id')               =>      strtoupper(@$foundationData['UnitID']),
            config('foundation.position.name')                  =>      @$foundationData['Name'],
            config('foundation.position.description')           =>      @$foundationData['Description'],
            config('foundation.position.is_active')             =>      isset($foundationData['Status'])?$foundationData['Status']:0,
            config('foundation.position.country_code')          =>      2
        ];

        unset($dataOut['']);

        return $dataOut;
    }

    public static function toCnInitializeModel($foundationData)
    {
        $dataOut = [
            config('foundation.position.id')                    =>      strtoupper(@$foundationData['id']),
            config('foundation.position.name')                  =>      @$foundationData['name'],
            config('foundation.position.description')           =>      @$foundationData['description'],
            config('foundation.position.unit_id')               =>      strtoupper(@$foundationData['unitID']),
            config('foundation.position.created_date')          =>      @$foundationData['createdDate'],
            config('foundation.position.created_by')            =>      @$foundationData['createdBy'],
            config('foundation.position.last_modified_date')    =>      isset($foundationData['lastModifiedDate'])?date("Y-m-d H:i:s",strtotime(@$foundationData["lastModifiedDate"])):null,
            config('foundation.position.last_modified_by')      =>      isset($foundationData['lastModifiedBy'])?$foundationData['lastModifiedBy']:null,
            config('foundation.position.is_active')             =>      isset($foundationData['isActive'])?$foundationData['isActive']:0,
            config('foundation.position.country_code')          =>      1
        ];

        unset($dataOut['']);

        return $dataOut;
    }

    public static function toUsInitializeModel($foundationData)
    {
        $dataOut = [
            config('foundation.position.id')                    =>      strtoupper(@$foundationData['positionID']),
            config('foundation.position.name')                  =>      @$foundationData['name'],
            config('foundation.position.description')           =>      @$foundationData['description'],
            config('foundation.position.unit_id')               =>      strtoupper(@$foundationData['unitID']),
            config('foundation.position.is_active')             =>      isset($foundationData['status'])?$foundationData['status']:0,
            config('foundation.position.country_code')          =>      2
        ];

        unset($dataOut['']);

        return $dataOut;
    }
}