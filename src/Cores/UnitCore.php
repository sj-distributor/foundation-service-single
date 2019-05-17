<?php
/**
 * Created by PhpStorm.
 * User: ben
 * Date: 2018/8/3
 * Time: 0:27
 */

namespace Wiltechsteam\FoundationServiceSingle\Cores;



class UnitCore
{
    public static function createInitializeList($unitList,$countryCode)
    {
        $unitData  =  array();
        foreach ($unitList as $unit)
        {
            $unitData[] = $countryCode == 1 ?
                self::toCnInitializeModel($unit) :
                self::toUsInitializeModel($unit);
        }
        return $unitData;
    }


    public static function toCnModel($foundationData)
    {
        $dataOut = [
            config('foundation.unit.id')	                            =>	    strtoupper(@$foundationData['unitID']),
            config('foundation.unit.created_date')                      =>      @$foundationData['createdDate'],
            config('foundation.unit.created_by')                        =>      @$foundationData['createdBy'],
            config('foundation.unit.last_modified_date')                =>      isset($foundationData['lastModifiedDate'])?date("Y-m-d H:i:s",strtotime(@$foundationData["lastModifiedDate"])):null,
            config('foundation.unit.last_modified_by')                  =>      isset($foundationData['lastModifiedBy'])?$foundationData['lastModifiedBy']:null,
            config('foundation.unit.name')	                        =>	    @$foundationData['name'],
            config('foundation.unit.type')	                            =>	    strtoupper(@$foundationData['typeID']),
            config('foundation.unit.parent_id')	                        =>	   empty($foundationData['parentID'])?null:strtoupper(@$foundationData['parentID']),
            config('foundation.unit.parents_id')	                    =>	    strtoupper(@$foundationData['locationCode']),
            config('foundation.unit.description')	                    =>	    @$foundationData['description'],
            config('foundation.unit.leader_id')                         =>      strtoupper(@$foundationData['leaderID']),
            config('foundation.unit.is_active')                         =>      empty($foundationData['isActive'])?0:$foundationData['isActive'],
            config('foundation.unit.country_code')                      =>      1
        ];

        if(!empty($foundationData['leaderCountryCode']))
        {
            $dataOut['leader_country_code']     =       $foundationData['leaderCountryCode'];
        }

        unset($dataOut['']);

        return $dataOut;
    }

    public static function toUsModel($foundationData)
    {
        $dataOut =  [
            config('foundation.unit.id')	                            =>	    strtoupper(@$foundationData['UnitID']),
            config('foundation.unit.name')	                        =>	    @$foundationData['Name'],
            config('foundation.unit.type')	                            =>	    strtoupper(@$foundationData['TypeID']),
            config('foundation.unit.parent_id')	                        =>	    empty($foundationData['ParentID'])?null:strtoupper(@$foundationData['ParentID']),
            config('foundation.unit.parents_id')	                    =>	    strtoupper(@$foundationData['LocationCode']),
            config('foundation.unit.leader_id')                         =>      strtoupper(@$foundationData['leaderID']),
            config('foundation.unit.is_active')                         =>      isset($foundationData['Status'])?$foundationData['Status']:0,
            config('foundation.unit.country_code')                      =>      2
        ];

        if(!empty($foundationData['leaderCountryCode']))
        {
            $dataOut[config('foundation.unit.leader_country_code')]     =       $foundationData['leaderCountryCode'];
        }

        unset($dataOut['']);

        return $dataOut;
    }


    public static function toCnMovedModel($foundationData)
    {
        $dataOut = [
            config('foundation.unit.id')	                            =>	    strtoupper(@$foundationData['unitID']),
            config('foundation.unit.parent_id')	                        =>	    strtoupper(@$foundationData['parentID']),
            config('foundation.unit.parents_id')	                    =>      strtoupper(@$foundationData['locationCode'])
        ];

        unset($dataOut['']);

        return $dataOut;
    }

    public static function toCnChildModel($foundationData)
    {
        $dataOut = [
            config('foundation.unit.id')	                            =>	    strtoupper(@$foundationData['unitID']),
            config('foundation.unit.parents_id')	                    =>      strtoupper(@$foundationData['locationCode'])
        ];

        unset($dataOut['']);

        return $dataOut;
    }

    public static function toCnInitializeModel($foundationData)
    {
        $dataOut = [
            config('foundation.unit.id')	                            =>	    strtoupper(@$foundationData['id']),
            config('foundation.unit.created_date')                      =>      @$foundationData['createdDate'],
            config('foundation.unit.created_by')                        =>      @$foundationData['createdBy'],
            config('foundation.unit.last_modified_date')                =>      isset($foundationData['lastModifiedDate'])?date("Y-m-d H:i:s",strtotime(@$foundationData["lastModifiedDate"])):null,
            config('foundation.unit.last_modified_by')                  =>      isset($foundationData['lastModifiedBy'])?$foundationData['lastModifiedBy']:null,
            config('foundation.unit.name')	                            =>	    @$foundationData['name'],
            config('foundation.unit.description')                       =>      @$foundationData['description'],
            config('foundation.unit.type')	                            =>	    strtoupper(@$foundationData['typeID']),
            config('foundation.unit.parent_id')	                        =>	    !empty($foundationData['parentID'])?strtoupper($foundationData['parentID']):null,
            config('foundation.unit.leader_id')                         =>      isset($foundationData['leaderID'])?strtoupper($foundationData['leaderID']):null,
            config('foundation.unit.leader_country_code')               =>      isset($foundationData['leaderCountryCode'])?$foundationData['leaderCountryCode']:null,
            config('foundation.unit.parents_id')	                    =>	    isset($foundationData['locationCode'])?strtoupper($foundationData['locationCode']):null,
            config('foundation.unit.is_active')                         =>      isset($foundationData['isActive'])?$foundationData['isActive']:0,
            config('foundation.unit.country_code')                      =>      1
        ];

        unset($dataOut['']);

        return $dataOut;
    }

    public static function toUsInitializeModel($foundationData)
    {
        $dataOut = [
            config('foundation.unit.id')	                            =>  	strtoupper(@$foundationData['unitID']),
            config('foundation.unit.name')	                            =>  	@$foundationData['name'],
            config('foundation.unit.description')                       =>      @$foundationData['description'],
            config('foundation.unit.type')	                            =>	    strtoupper(@$foundationData['typeID']),
            config('foundation.unit.parent_id')	                        =>	    empty($foundationData['parentID'])?null:strtoupper(@$foundationData['parentID']),
            config('foundation.unit.leader_id')                         =>      strtoupper(@$foundationData['leaderID']),
            config('foundation.unit.leader_country_code')               =>      isset($foundationData['leaderCountryCode'])?$foundationData['leaderCountryCode']:null,
            config('foundation.unit.parents_id')	                    =>	    strtoupper(@$foundationData['locationCode']),
            config('foundation.unit.is_active')                         =>      isset($foundationData['status'])?$foundationData['status']:0,
            config('foundation.unit.country_code')                      =>      2
        ];

        unset($dataOut['']);

        return $dataOut;
    }
}