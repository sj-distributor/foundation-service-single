<?php
/**
 * Created by PhpStorm.
 * User: ben
 * Date: 2018/8/3
 * Time: 0:03
 */

namespace Wiltechsteam\FoundationServiceSingle\Cores;

class StaffCore
{
    public static function createInitializeList($staffList,$countryCode)
    {
        $staffData  =  array();
        foreach ($staffList as $staff)
        {
            $staffData[] = $countryCode == 1 ?
                self::toCnInitializeModel($staff) :
                self::toUsInitializeModel($staff);
        }
        return $staffData;
    }

    public static function createInitializeListUnitAndPosition($staffList,$unitList,$positionList,$countryCode)
    {
        $staffData  =  array();
        foreach ($staffList as $staff)
        {
            if($countryCode == 1)
            {
                $item = self::toCnInitializeModel($staff);
                $item = self::addDepartmentNameAndGroupName($item,$unitList);
                $item = self::addPositionName($item,$positionList);
               // $item = self::addSuperiorId($item,$unitList);
            }else
            {
                $item =self::toUsInitializeModel($staff);
            }
            $staffData[] = $item;
        }
        return $staffData;
    }


    public static function addDepartmentNameAndGroupName($staff,$unitList)
    {
        foreach ($unitList as $unit)
        {

            if($unit["id"] == $staff["department_id"])
            {
                $staff["department_name"] = $unit["unit_name"];
            }

            if($unit["id"] == $staff["group_id"])
            {
                $staff["group_name"] = $unit["unit_name"];
            }
        }
        return $staff;
    }


    public static function addSuperiorId($staff,$unitList)
    {
        $unitId = $staff["group_id"];

        if(empty($staff["group_id"]))
        {
            $unitId = $staff["department_id"];
        }

        if(empty($staff["department_id"]))
        {
            $unitId = $staff["company_id"];
        }

        foreach ($unitList as $unit)
        {

            if($unit["id"] == $unitId)
            {
                $staff["superior_id"] = $unit["leader_id"];
            }
        }
        return $staff;
    }


    public static  function addPositionName($staff,$positionList)
    {
        foreach ($positionList as $position)
        {
            if($position["id"] == $staff["position_id"])
            {
                $staff["position_name"] = $position["name"];
            }
        }
        return $staff;
    }

    public static function toUsModel($foundationData)
    {
        return [
            "id"						        =>	    strtoupper(@$foundationData["StaffID"]),
            "user_id"		                    =>	    strtoupper(@$foundationData["UserID"]),
            "username"		                    =>	    @$foundationData["UserName"],
            "name_en_long"				        =>	    @$foundationData["PayrollName"],
            "gender"                            =>      @$foundationData['Gender'],
            "department_id"				        =>	    strtoupper(@$foundationData["DepartmentID"]),
            //"department_name"		            =>	    @$foundationData["DepartmentName"],
            "group_id"					        =>	    strtoupper(@$foundationData["GroupID"]),
           // "group_name"		                =>	    @$foundationData["GroupName"],
            "position_id"		                =>	    strtoupper(@$foundationData["PositionID"]),
           // "position_name"		                =>	    @$foundationData["PositionName"],
            "identity_card_number"              =>      @$foundationData['SSN'],
            "dob"                               =>      date("Y-m-d",strtotime(@$foundationData['DOB'])),
            "address1"                          =>      @$foundationData['Address'],
            "phone_number"                      =>      @$foundationData['PersonalMobile'],
            "emergency_contact"                 =>      @$foundationData['EmergencyContact'],
            "emergency_contact_phone_number"    =>      @$foundationData['EmergencyTel'],
            "position_status"                   =>      isset($foundationData["PositionStatus"])?$foundationData["PositionStatus"]:0,
            "hired_date"				        =>	    date("Y-m-d H:i:s",strtotime(@$foundationData["HiredDate"])),
            "terminated_date"                   =>      date("Y-m-d",strtotime(@$foundationData['TerminatedDate'])),
            "country_code"		                =>	    2,
        ];
    }

    public static function toCnModel($foundationData)
    {
        $dataOut = [
            "id"						        =>  	strtoupper(@$foundationData["staffID"]),
            "serial_number"				        =>  	@$foundationData["serialNumber"],
            "name_cn_long"				        =>  	@$foundationData["nameCNLong"],
            "name_en_long"				        =>  	@$foundationData["nameENLong"],
            "gender"                            =>      isset($foundationData["gender"])?$foundationData['gender']:0,
            "department_id"				        =>  	strtoupper(@$foundationData["departmentID"]),
           // "department_name"			        =>  	@$foundationData["departmentName"],
            "group_id"					        =>  	strtoupper(@$foundationData["groupID"]),
           // "group_name"				        =>  	@$foundationData["groupName"],
            "position_id"				        =>  	strtoupper(@$foundationData["positionID"]),
            //"position_name"				        =>  	@$foundationData["positionName"],
            "superior_id"				        =>  	strtoupper(@$foundationData["superiorID"]),
            "company_id"	                    =>	    strtoupper(@$foundationData["companyID"]),
           // "company_name"	                    =>	    @$foundationData["companyName"],
            "identity_card_number"	        	=>  	@$foundationData["identityCardNumber"],
            "dob"						        =>  	empty($foundationData["dob"]) ?null:date("Y-m-d",strtotime(@$foundationData["dob"])),
            "nation"					        =>  	@$foundationData["nation"],
            "political_status"                  =>      isset($foundationData["politicalStatus"])?$foundationData["politicalStatus"]:null,
            "marital_status"                    =>      isset($foundationData["maritalStatus"])?$foundationData['maritalStatus']:0,
            "fertility_status"                  =>      isset($foundationData["fertilityStatus"])?$foundationData['fertilityStatus']:0,
            "household_category"		        =>  	@$foundationData["householdCategory"],
            "household_location"		        =>  	@$foundationData["householdLocation"],
            "graduation_school"			        =>  	@$foundationData["graduationSchool"],
            "major"						        =>  	@$foundationData["major"],
            "education"                         =>      isset($foundationData["education"])?$foundationData['education']:null,
            "bank_name"					        =>  	@$foundationData["bankName"],
            "bank_number"			        	=>  	@$foundationData["bankNumber"],
            "phone_number"			        	=>  	@$foundationData["phoneNumber"],
            "email"						        =>  	@$foundationData["email"],
            "hired_date"				        =>  	empty($foundationData["hiredDate"])?null:date("Y-m-d H:i:s",strtotime(@$foundationData["hiredDate"])),
            "contract_status"                   =>      isset($foundationData["contractStatus"])?$foundationData['contractStatus']:0,
            "finger_print_number"		        =>  	@$foundationData["fingerPrintNumber"],
            "work_place"				        =>	    @$foundationData["workPlace"],
            "position_status"                   =>      isset($foundationData["positionStatus"])?$foundationData["positionStatus"]:0,
            "address1"					        =>	    @$foundationData["address1"],
            "address2"					        =>	    @$foundationData["address2"],
            "emergency_contact"			        =>	    @$foundationData["emergencyContact"],
            "emergency_contact_phone_number"	=>	    @$foundationData["emergencyContactPhoneNumber"],
            "entrance_guard_number"	            =>	    @$foundationData["entranceGuardNumber"],
            "seat_number"	                    =>	    @$foundationData["seatNumber"],
            "current_address"	                =>	    @$foundationData["currentAddress"],
            "country_code"                      =>      1
        ];


        if (isset($foundationData["terminatedDate"])){
            $dataOut["terminated_date"]         =       date("Y-m-d H:i:s",strtotime(@$foundationData["terminatedDate"]));
        }
        if (isset($foundationData["internshipStartDate"])){
            $dataOut["internship_start_date"]   =       date("Y-m-d H:i:s",strtotime(@$foundationData["internshipStartDate"]));
        }
        if (isset($foundationData["internshipEndDate"])){
            $dataOut["internship_end_date"]     =       date("Y-m-d H:i:s",strtotime(@$foundationData["internshipEndDate"]));
        }

        return $dataOut;
    }

    public static function toCnInitializeModel($foundationData)
    {
        return [
            "id"                                =>      strtoupper(@$foundationData["id"]),
            "user_id"                           =>      isset($foundationData["userID"])?strtoupper($foundationData['userID']):null,
            "user_name"                          =>      isset($foundationData["userName"])?$foundationData['userName']:null,
            "serial_number"                     =>      @$foundationData["serialNumber"],
            "name_cn_long"                      =>      @$foundationData["nameCNLong"],
            "name_en_long"                      =>      @$foundationData["nameENLong"],
            "gender"                            =>      isset($foundationData["gender"])?$foundationData['gender']:0,
            "company_id"                        =>      strtoupper(@$foundationData["companyID"]),
            //"company_name"                      =>      @$foundationData["companyName"],
            "department_id"                     =>      strtoupper(@$foundationData["departmentID"]),
            //"department_name"                   =>      @$foundationData["departmentName"],
            "group_id"                          =>      strtoupper(@$foundationData["groupID"]),
           // "group_name"                        =>      @$foundationData["groupName"],
            "position_id"                       =>      strtoupper(@$foundationData["positionID"]),
           // "position_name"                     =>      @$foundationData["positionName"],
            "superior_id"                       =>      strtoupper(@$foundationData["superiorID"]),
            "identity_card_number"              =>      @$foundationData["identityCardNumber"],
            "dob"                               =>      empty($foundationData["dob"])?null:date("Y-m-d",strtotime(@$foundationData["dob"])),
            "nation"                            =>      @$foundationData["nation"],
            "political_status"                  =>      isset($foundationData["politicalStatus"])?$foundationData["politicalStatus"]:null,
            "marital_status"                    =>      isset($foundationData["maritalStatus"])?$foundationData['maritalStatus']:0,
            "fertility_status"                  =>      isset($foundationData["fertilityStatus"])?$foundationData['fertilityStatus']:0,
            "household_category"                =>      @$foundationData["householdCategory"],
            "household_location"                =>      @$foundationData["householdLocation"],
            "graduation_school"                 =>      @$foundationData["graduationSchool"],
            "major"                             =>      @$foundationData["major"],
            "education"                         =>      isset($foundationData["education"])?$foundationData['education']:null,
            "bank_name"                         =>      @$foundationData["bankName"],
            "bank_number"                       =>      @$foundationData["bankNumber"],
            "phone_number"                      =>      @$foundationData["phoneNumber"],
            "email"                             =>      @$foundationData["email"],
            "hired_date"                        =>      date("Y-m-d H:i:s",strtotime(@$foundationData["hiredDate"])),
            "contract_status"                   =>      isset($foundationData["contractStatus"])?$foundationData['contractStatus']:0,
            "finger_print_number"               =>      @$foundationData["fingerPrintNumber"],
            "work_place"                        =>      @$foundationData["workPlace"],
            "position_status"                   =>      isset($foundationData["positionStatus"])?$foundationData["positionStatus"]:0,
            "terminated_date"                   =>      isset($foundationData["terminatedDate"])?date("Y-m-d H:i:s",strtotime(@$foundationData["terminatedDate"])):null,
            "internship_start_date"             =>      isset($foundationData["internshipStartDate"])?date("Y-m-d H:i:s",strtotime(@$foundationData["internshipStartDate"])):null,
            "internship_end_date"               =>      isset($foundationData["internshipEndDate"])?date("Y-m-d H:i:s",strtotime(@$foundationData["internshipEndDate"])):null,
            "address1"                          =>      @$foundationData["address1"],
            "address2"                          =>      @$foundationData["address2"],
            "emergency_contact"                 =>      @$foundationData["emergencyContact"],
            "emergency_contact_phone_number"    =>      @$foundationData["emergencyContactPhoneNumber"],
            "created_date"                      =>      isset($foundationData['createdDate'])?date("Y-m-d H:i:s",strtotime(@$foundationData["createdDate"])):null,
            "created_by"                        =>      isset($foundationData['createdBy'])?$foundationData['createdBy']:null,
            "last_modified_date"                =>      isset($foundationData['lastModifiedDate'])?date("Y-m-d H:i:s",strtotime(@$foundationData["lastModifiedDate"])):null,
            "last_modified_by"                  =>      isset($foundationData['lastModifiedBy'])?$foundationData['lastModifiedBy']:null,
            "entrance_guard_number"	            =>	    @$foundationData["entranceGuardNumber"],
            "seat_number"	                    =>	    @$foundationData["seatNumber"],
            "current_address"	                =>	    @$foundationData["currentAddress"],
            "country_code"                      =>      1
        ];
    }

    public static function toUsInitializeModel($foundationData)
    {
        return [
            "id"                                =>      strtoupper($foundationData['staffID']),
            "user_id"                           =>      empty($foundationData['userID'])?null:strtoupper($foundationData['userID']),
            "user_name"                          =>      empty($foundationData['userName'])?null:strtoupper($foundationData['userName']),
            "name_en_long"                      =>      @$foundationData['payrollName'],
            "gender"                            =>      @$foundationData['gender'],
            "department_id"                     =>      strtoupper(@$foundationData['departmentID']),
          //  "department_name"                   =>      @$foundationData['departmentName'],
            "group_id"                          =>      strtoupper(@$foundationData['groupID']),
           // "group_name"                        =>      @$foundationData['groupName'],
            "position_id"                       =>      strtoupper(@$foundationData['positionID']),
           // "position_name"                     =>      @$foundationData['positionName'],
            "identity_card_number"              =>      @$foundationData['ssn'],
            "dob"                               =>      date("Y-m-d",strtotime(@$foundationData['dob'])),
            "address1"                          =>      @$foundationData['address'],
            "phone_number"                      =>      @$foundationData['personalMobile'],
            "emergency_contact"                 =>      @$foundationData['emergencyContact'],
            "emergency_contact_phone_number"    =>      @$foundationData['emergencyTel'],
            "position_status"                   =>      @$foundationData['positionStatus'],
            "hired_date"                        =>      date("Y-m-d",strtotime(@$foundationData['hiredDate'])),
            "terminated_date"                   =>      date("Y-m-d",strtotime(@$foundationData['terminatedDate'])),
            "country_code"		                =>	    2
        ];
    }

    public static function toUserUpdateModel($foundationData)
    {
        return [
            "id"	                            =>	    strtoupper(@$foundationData['staffID']),
            "username"	                        =>	    @$foundationData['userName'],
            "user_id"	                        =>	    strtoupper(@$foundationData['userID'])
        ];
    }


    public static function addStaffUnitName($unit)
    {
        if($unit["type"] == 8)
        {
            return ["company_name"  =>  $unit["unit_name"]];
        }

        if($unit["type"] == 4)
        {
            return ["department_name"  =>  $unit["unit_name"]];
        }

        if($unit["type"] == 2)
        {
            return ["group_name"  =>  $unit["unit_name"]];
        }

        return null;
    }
}