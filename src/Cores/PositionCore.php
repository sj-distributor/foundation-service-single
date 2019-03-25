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
        return [
            "id"                    =>      strtoupper(@$foundationData['positionID']),
            "unit_id"               =>      strtoupper(@$foundationData['unitID']),
            "name"                  =>      @$foundationData['name'],
            "description"           =>      @$foundationData['description'],
            "is_active"             =>      empty($foundationData['isActive'])?0:$foundationData['isActive'],
            "country_code"          =>      1
        ];
    }

    public static function toUsModel($foundationData)
    {
        return [
            "id"                    =>      strtoupper(@$foundationData['PositionID']),
            "unit_id"               =>      strtoupper(@$foundationData['UnitID']),
            "name"                  =>      @$foundationData['Name'],
            "description"           =>      @$foundationData['Description'],
            "is_active"             =>      isset($foundationData['Status'])?$foundationData['Status']:0,
            "country_code"          =>      2
        ];
    }

    public static function toCnInitializeModel($foundationData)
    {
        return [
            "id"                    =>      strtoupper(@$foundationData['id']),
            "name"                  =>      @$foundationData['name'],
            "description"           =>      @$foundationData['description'],
            "unit_id"               =>      strtoupper(@$foundationData['unitID']),
            "created_date"          =>      @$foundationData['createdDate'],
            "created_by"            =>      @$foundationData['createdBy'],
            "last_modified_date"    =>      isset($foundationData['lastModifiedDate'])?date("Y-m-d H:i:s",strtotime(@$foundationData["lastModifiedDate"])):null,
            "last_modified_by"      =>      isset($foundationData['lastModifiedBy'])?$foundationData['lastModifiedBy']:null,
            "is_active"             =>      isset($foundationData['isActive'])?$foundationData['isActive']:0,
            "country_code"          =>      1
        ];
    }

    public static function toUsInitializeModel($foundationData)
    {
        return [
            "id"                    =>      strtoupper(@$foundationData['positionID']),
            "name"                  =>      @$foundationData['name'],
            "description"           =>      @$foundationData['description'],
            "unit_id"               =>      strtoupper(@$foundationData['unitID']),
            "is_active"             =>      isset($foundationData['status'])?$foundationData['status']:0,
            "country_code"          =>      2
        ];
    }
}