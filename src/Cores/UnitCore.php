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
            "id"	                            =>	    strtoupper(@$foundationData['unitID']),
            "unit_name"	                        =>	    @$foundationData['name'],
            "type"	                            =>	    strtoupper(@$foundationData['typeID']),
            "parent_id"	                        =>	   empty($foundationData['parentID'])?null:strtoupper(@$foundationData['parentID']),
            "parents_id"	                    =>	    strtoupper(@$foundationData['locationCode']),
            "description"	                    =>	    @$foundationData['description'],
            "leader_id"                         =>      strtoupper(@$foundationData['leaderID']),
            "is_active"                         =>      empty($foundationData['isActive'])?0:$foundationData['isActive'],
            "country_code"                      =>      1
        ];

        if(!empty($foundationData['leaderCountryCode']))
        {
            $dataOut['leader_country_code']     =       $foundationData['leaderCountryCode'];
        }

        return $dataOut;
    }

    public static function toUsModel($foundationData)
    {
        $dataOut =  [
            "id"	                            =>	    strtoupper(@$foundationData['UnitID']),
            "unit_name"	                        =>	    @$foundationData['Name'],
            "type"	                            =>	    strtoupper(@$foundationData['TypeID']),
            "parent_id"	                        =>	    empty($foundationData['ParentID'])?null:strtoupper(@$foundationData['ParentID']),
            "parents_id"	                    =>	    strtoupper(@$foundationData['LocationCode']),
            "leader_id"                         =>      strtoupper(@$foundationData['leaderID']),
            "is_active"                         =>      isset($foundationData['Status'])?$foundationData['Status']:0,
            "country_code"                      =>      2
        ];

        if(!empty($foundationData['leaderCountryCode']))
        {
            $dataOut['leader_country_code']     =       $foundationData['leaderCountryCode'];
        }

        return $dataOut;
    }


    public static function toCnMovedModel($foundationData)
    {
        return [
            "id"	                            =>	    strtoupper(@$foundationData['unitID']),
            "parent_id"	                        =>	    strtoupper(@$foundationData['parentID']),
            "parents_id"	                    =>      strtoupper(@$foundationData['locationCode'])
        ];
    }

    public static function toCnChildModel($foundationData)
    {
        return [
            "id"	                            =>	    strtoupper(@$foundationData['unitID']),
            "parents_id"	                    =>      strtoupper(@$foundationData['locationCode'])
        ];
    }

    public static function toCnInitializeModel($foundationData)
    {
        return [
            "id"	                            =>	    strtoupper(@$foundationData['id']),
            "unit_name"	                        =>	    @$foundationData['name'],
            "description"                       =>      @$foundationData['description'],
            "type"	                            =>	    strtoupper(@$foundationData['typeID']),
            "parent_id"	                        =>	    !empty($foundationData['parentID'])?strtoupper($foundationData['parentID']):null,
            "leader_id"                         =>      isset($foundationData['leaderID'])?strtoupper($foundationData['leaderID']):null,
            "leader_country_code"               =>      isset($foundationData['leaderCountryCode'])?$foundationData['leaderCountryCode']:null,
            "parents_id"	                    =>	    isset($foundationData['locationCode'])?strtoupper($foundationData['locationCode']):null,
            "is_active"                         =>      isset($foundationData['isActive'])?$foundationData['isActive']:0,
            "country_code"                      =>      1
        ];
    }

    public static function toUsInitializeModel($foundationData)
    {
        return [
            "id"	                            =>  	strtoupper(@$foundationData['unitID']),
            "unit_name"	                        =>  	@$foundationData['name'],
            "description"                       =>      @$foundationData['description'],
            "type"	                            =>	    strtoupper(@$foundationData['typeID']),
            "parent_id"	                        =>	    empty($foundationData['parentID'])?null:strtoupper(@$foundationData['parentID']),
            "leader_id"                         =>      strtoupper(@$foundationData['leaderID']),
            "leader_country_code"               =>      isset($foundationData['leaderCountryCode'])?$foundationData['leaderCountryCode']:null,
            "parents_id"	                    =>	    strtoupper(@$foundationData['locationCode']),
            "is_active"                         =>      isset($foundationData['status'])?$foundationData['status']:0,
            "country_code"                      =>      2
        ];
    }
}