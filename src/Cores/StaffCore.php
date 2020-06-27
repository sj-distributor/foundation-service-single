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
                $item = self::addSuperiorId($item,$unitList);
                $item = self::addCompanyName($item, $unitList);
            }else
            {
                $item =self::toUsInitializeModel($staff);
                $item = self::addDepartmentNameAndGroupName($item,$unitList);
                $item = self::addPositionName($item,$positionList);
                $item = self::addSuperiorId($item,$unitList);
                $item = self::addCompanyName($item, $unitList);
            }
            $staffData[] = $item;
        }
        return $staffData;
    }


    public static function addDepartmentNameAndGroupName($staff,$unitList)
    {
        foreach ($unitList as $unit)
        {

            if($unit[config('foundation.unit.id')] == $staff[config('foundation.staff.department_id')])
            {
                $staff[config('foundation.staff.department_name')] = $unit[config('foundation.unit.name')];
            }

            if($unit[config('foundation.unit.id')] == $staff[config('foundation.staff.group_id')])
            {
                $staff[config('foundation.staff.group_name')] = $unit[config('foundation.unit.name')];
            }
        }
        return $staff;
    }

    public static function addCompanyName($staff,$unitList)
    {
        foreach ($unitList as $unit)
        {
            if($unit[config('foundation.unit.id')] == $staff[config('foundation.staff.company_id')])
            {
                    $staff[config('foundation.staff.company_name')] = $unit[config('foundation.unit.name')];
            }
            
        }
        return $staff;
    }


    public static function addSuperiorId($staff,$unitList)
    {
        $unitId = $staff[config('foundation.staff.group_id')];

        if(empty($staff[config('foundation.staff.group_id')]))
        {
            $unitId = $staff[config('foundation.staff.department_id')];
        }

        if(empty($staff[config('foundation.staff.department_id')]))
        {
            $unitId = $staff[config('foundation.staff.company_id')];
        }

        foreach ($unitList as $unit)
        {

            if($unit[config('foundation.unit.id')] == $unitId)
            {
                $staff[config('foundation.staff.superior_id')] = $unit[config('foundation.unit.leader_id')];
            }
        }
        return $staff;
    }


    public static  function addPositionName($staff,$positionList)
    {
        foreach ($positionList as $position)
        {
            if($position[config('foundation.position.id')] == $staff[config('foundation.staff.position_id')])
            {
                $staff[config('foundation.staff.position_name')] = $position[config('foundation.position.name')];
            }
        }
        return $staff;
    }

    public static function toUsModel($foundationData)
    {
        $dataOut = [
            config('foundation.staff.id')						        =>	    strtoupper(@$foundationData["StaffID"]),
            config('foundation.staff.user_id')		                    =>	    strtoupper(@$foundationData["UserID"]),
            config('foundation.staff.user_name')		                    =>	    @$foundationData["UserName"],
            config('foundation.staff.name_en_long')				        =>	    @$foundationData["PayrollName"],
            config('foundation.staff.gender')                            =>      @$foundationData['Gender'],
            config('foundation.staff.department_id')				        =>	    strtoupper(@$foundationData["DepartmentID"]),
            // config('foundation.staff.department_name')		            =>	    @$foundationData["DepartmentName"],
            config('foundation.staff.group_id')					        =>	    strtoupper(@$foundationData["GroupID"]),
            // config('foundation.staff.group_name')		                =>	    @$foundationData["GroupName"],
            config('foundation.staff.position_id')		                =>	    strtoupper(@$foundationData["PositionID"]),
            // config('foundation.staff.position_name')		                =>	    @$foundationData["PositionName"],
            config('foundation.staff.identity_card_number')              =>      @$foundationData['SSN'],
            config('foundation.staff.dob')                               =>      date("Y-m-d",strtotime(@$foundationData['DOB'])),
            config('foundation.staff.address1')                          =>      @$foundationData['Address'],
            config('foundation.staff.phone_number')                      =>      @$foundationData['PersonalMobile'],
            config('foundation.staff.emergency_contact')                 =>      @$foundationData['EmergencyContact'],
            config('foundation.staff.emergency_contact_phone_number')    =>      @$foundationData['EmergencyTel'],
            config('foundation.staff.position_status')                   =>      isset($foundationData["PositionStatus"])?$foundationData["PositionStatus"]:0,
            config('foundation.staff.hired_date')				        =>	    date("Y-m-d H:i:s",strtotime(@$foundationData["HiredDate"])),
            config('foundation.staff.terminated_date')                  =>      date("Y-m-d",strtotime(@$foundationData['TerminatedDate'])),
            config('foundation.staff.country_code')		                =>	    2,
            config('foundation.staff.company_id')		                 =>	     @$foundationData['CompanyId'],
            config('foundation.staff.company_name')		                 =>	     @$foundationData['CompanyName'],
            config('foundation.staff.location_description')		         =>	     @$foundationData['LocationDescription'],
            config('foundation.staff.driver_code')		                 =>	     @$foundationData['DriverCode'],
            config('foundation.staff.badge')		                     =>	     @$foundationData['Badge'],
        ];

        unset($dataOut['']);

        return $dataOut;
    }

    public static function toCnModel($foundationData)
    {
        $dataOut = [
            config('foundation.staff.id')						        =>  	strtoupper(@$foundationData["staffID"]),
            config('foundation.staff.serial_number')				        =>  	@$foundationData["serialNumber"],
            config('foundation.staff.name_cn_long')				        =>  	@$foundationData["nameCNLong"],
            config('foundation.staff.name_en_long')				        =>  	@$foundationData["nameENLong"],
            config('foundation.staff.gender')                            =>      isset($foundationData["gender"])?$foundationData['gender']:0,
            config('foundation.staff.department_id')				        =>  	strtoupper(@$foundationData["departmentID"]),
            // config('foundation.staff.department_name')			        =>  	@$foundationData["departmentName"],
            config('foundation.staff.group_id')					        =>  	strtoupper(@$foundationData["groupID"]),
            // config('foundation.staff.group_name')				        =>  	@$foundationData["groupName"],
            config('foundation.staff.position_id')				        =>  	strtoupper(@$foundationData["positionID"]),
            // config('foundation.staff.position_name')				        =>  	@$foundationData["positionName"],
            config('foundation.staff.superior_id')				        =>  	strtoupper(@$foundationData["superiorID"]),
            config('foundation.staff.company_id')	                    =>	    strtoupper(@$foundationData["companyID"]),
            // config('foundation.staff.company_name')	                    =>	    @$foundationData["companyName"],
            config('foundation.staff.identity_card_number')	        	=>  	@$foundationData["identityCardNumber"],
            config('foundation.staff.dob')						        =>  	empty($foundationData["dob"]) ?null:date("Y-m-d",strtotime(@$foundationData["dob"])),
            config('foundation.staff.nation')					        =>  	@$foundationData["nation"],
            config('foundation.staff.political_status')                  =>      isset($foundationData["politicalStatus"])?$foundationData["politicalStatus"]:null,
            config('foundation.staff.marital_status')                    =>      isset($foundationData["maritalStatus"])?$foundationData['maritalStatus']:0,
            config('foundation.staff.fertility_status')                  =>      isset($foundationData["fertilityStatus"])?$foundationData['fertilityStatus']:0,
            config('foundation.staff.household_category')		        =>  	@$foundationData["householdCategory"],
            config('foundation.staff.household_location')		        =>  	@$foundationData["householdLocation"],
            config('foundation.staff.graduation_school')			        =>  	@$foundationData["graduationSchool"],
            config('foundation.staff.major')						        =>  	@$foundationData["major"],
            config('foundation.staff.education')                         =>      isset($foundationData["education"])?$foundationData['education']:null,
            config('foundation.staff.bank_name')					        =>  	@$foundationData["bankName"],
            config('foundation.staff.bank_number')			        	=>  	@$foundationData["bankNumber"],
            config('foundation.staff.phone_number')			        	=>  	@$foundationData["phoneNumber"],
            config('foundation.staff.email')						        =>  	@$foundationData["email"],
            config('foundation.staff.hired_date')				        =>  	empty($foundationData["hiredDate"])?null:date("Y-m-d H:i:s",strtotime(@$foundationData["hiredDate"])),
            config('foundation.staff.contract_status')                   =>      isset($foundationData["contractStatus"])?$foundationData['contractStatus']:0,
            config('foundation.staff.finger_print_number')		        =>  	@$foundationData["fingerPrintNumber"],
            config('foundation.staff.work_place')				        =>	    @$foundationData["workPlace"],
            config('foundation.staff.position_status')                   =>      isset($foundationData["positionStatus"])?$foundationData["positionStatus"]:0,
            config('foundation.staff.address1')					        =>	    @$foundationData["address1"],
            config('foundation.staff.address2')					        =>	    @$foundationData["address2"],
            config('foundation.staff.emergency_contact')			        =>	    @$foundationData["emergencyContact"],
            config('foundation.staff.emergency_contact_phone_number')	=>	    @$foundationData["emergencyContactPhoneNumber"],
            config('foundation.staff.entrance_guard_number')	            =>	    @$foundationData["entranceGuardNumber"],
            config('foundation.staff.seat_number')	                    =>	    @$foundationData["seatNumber"],
            config('foundation.staff.current_address')	                =>	    @$foundationData["currentAddress"],
            config('foundation.staff.country_code')                      =>      1
        ];


        if (isset($foundationData["terminatedDate"])){
            $dataOut[config('foundation.staff.terminated_date')]         =       date("Y-m-d H:i:s",strtotime(@$foundationData["terminatedDate"]));
        }
        if (isset($foundationData["internshipStartDate"])){
            $dataOut[config('foundation.staff.internship_start_date')]   =       date("Y-m-d H:i:s",strtotime(@$foundationData["internshipStartDate"]));
        }
        if (isset($foundationData["internshipEndDate"])){
            $dataOut[config('foundation.staff.internship_end_date')]     =       date("Y-m-d H:i:s",strtotime(@$foundationData["internshipEndDate"]));
        }

        unset($dataOut['']);

        return $dataOut;
    }

    public static function toCnInitializeModel($foundationData)
    {
        $dataOut = [
            config('foundation.staff.id')                                =>      strtoupper(@$foundationData["id"]),
            config('foundation.staff.user_id')                           =>      isset($foundationData["userID"])?strtoupper($foundationData['userID']):null,
            config('foundation.staff.user_name')                         =>      isset($foundationData["userName"])?$foundationData['userName']:null,
            config('foundation.staff.serial_number')                     =>      @$foundationData["serialNumber"],
            config('foundation.staff.name_cn_long')                      =>      @$foundationData["nameCNLong"],
            config('foundation.staff.name_en_long')                      =>      @$foundationData["nameENLong"],
            config('foundation.staff.gender')                            =>      isset($foundationData["gender"])?$foundationData['gender']:0,
            config('foundation.staff.company_id')                        =>      strtoupper(@$foundationData["companyID"]),
            //config('foundation.staff.company_name')                      =>      @$foundationData["companyName"],
            config('foundation.staff.department_id')                     =>      strtoupper(@$foundationData["departmentID"]),
            //config('foundation.staff.department_name')                   =>      @$foundationData["departmentName"],
            config('foundation.staff.group_id')                          =>      strtoupper(@$foundationData["groupID"]),
            // config('foundation.staff.group_name')                        =>      @$foundationData["groupName"],
            config('foundation.staff.position_id')                       =>      strtoupper(@$foundationData["positionID"]),
            // config('foundation.staff.position_name')                     =>      @$foundationData["positionName"],
            config('foundation.staff.superior_id')                       =>      strtoupper(@$foundationData["superiorID"]),
            config('foundation.staff.identity_card_number')              =>      @$foundationData["identityCardNumber"],
            config('foundation.staff.dob')                               =>      empty($foundationData["dob"])?null:date("Y-m-d",strtotime(@$foundationData["dob"])),
            config('foundation.staff.nation')                            =>      @$foundationData["nation"],
            config('foundation.staff.political_status')                  =>      isset($foundationData["politicalStatus"])?$foundationData["politicalStatus"]:null,
            config('foundation.staff.marital_status')                    =>      isset($foundationData["maritalStatus"])?$foundationData['maritalStatus']:0,
            config('foundation.staff.fertility_status')                  =>      isset($foundationData["fertilityStatus"])?$foundationData['fertilityStatus']:0,
            config('foundation.staff.household_category')                =>      @$foundationData["householdCategory"],
            config('foundation.staff.household_location')                =>      @$foundationData["householdLocation"],
            config('foundation.staff.graduation_school')                 =>      @$foundationData["graduationSchool"],
            config('foundation.staff.major')                             =>      @$foundationData["major"],
            config('foundation.staff.education')                         =>      isset($foundationData["education"])?$foundationData['education']:null,
            config('foundation.staff.bank_name')                         =>      @$foundationData["bankName"],
            config('foundation.staff.bank_number')                       =>      @$foundationData["bankNumber"],
            config('foundation.staff.phone_number')                      =>      @$foundationData["phoneNumber"],
            config('foundation.staff.email')                             =>      @$foundationData["email"],
            config('foundation.staff.hired_date')                        =>      date("Y-m-d H:i:s",strtotime(@$foundationData["hiredDate"])),
            config('foundation.staff.contract_status')                   =>      isset($foundationData["contractStatus"])?$foundationData['contractStatus']:0,
            config('foundation.staff.finger_print_number')               =>      @$foundationData["fingerPrintNumber"],
            config('foundation.staff.work_place')                        =>      @$foundationData["workPlace"],
            config('foundation.staff.position_status')                   =>      isset($foundationData["positionStatus"])?$foundationData["positionStatus"]:0,
            config('foundation.staff.terminated_date')                   =>      isset($foundationData["terminatedDate"])?date("Y-m-d H:i:s",strtotime(@$foundationData["terminatedDate"])):null,
            config('foundation.staff.internship_start_date')             =>      isset($foundationData["internshipStartDate"])?date("Y-m-d H:i:s",strtotime(@$foundationData["internshipStartDate"])):null,
            config('foundation.staff.internship_end_date')               =>      isset($foundationData["internshipEndDate"])?date("Y-m-d H:i:s",strtotime(@$foundationData["internshipEndDate"])):null,
            config('foundation.staff.address1')                          =>      @$foundationData["address1"],
            config('foundation.staff.address2')                          =>      @$foundationData["address2"],
            config('foundation.staff.emergency_contact')                 =>      @$foundationData["emergencyContact"],
            config('foundation.staff.emergency_contact_phone_number')    =>      @$foundationData["emergencyContactPhoneNumber"],
            config('foundation.staff.created_date')                      =>      isset($foundationData['createdDate'])?date("Y-m-d H:i:s",strtotime(@$foundationData["createdDate"])):null,
            config('foundation.staff.created_by')                        =>      isset($foundationData['createdBy'])?$foundationData['createdBy']:null,
            config('foundation.staff.last_modified_date')                =>      isset($foundationData['lastModifiedDate'])?date("Y-m-d H:i:s",strtotime(@$foundationData["lastModifiedDate"])):null,
            config('foundation.staff.last_modified_by')                  =>      isset($foundationData['lastModifiedBy'])?$foundationData['lastModifiedBy']:null,
            config('foundation.staff.entrance_guard_number')	         =>	     @$foundationData["entranceGuardNumber"],
            config('foundation.staff.seat_number')	                    =>	     @$foundationData["seatNumber"],
            config('foundation.staff.current_address')	                =>	     @$foundationData["currentAddress"],
            config('foundation.staff.country_code')                      =>      1
        ];

        unset($dataOut['']);

        return $dataOut;
    }

    public static function toUsInitializeModel($foundationData)
    {
        $dataOut = [
            config('foundation.staff.id')                                =>      strtoupper($foundationData['staffID']),
            config('foundation.staff.user_id')                           =>      empty($foundationData['userID'])?null:strtoupper($foundationData['userID']),
            config('foundation.staff.user_name')                         =>      empty($foundationData['userName'])?null:strtoupper($foundationData['userName']),
            config('foundation.staff.name_en_long')                      =>      @$foundationData['payrollName'],
            config('foundation.staff.gender')                            =>      @$foundationData['gender'],
            config('foundation.staff.department_id')                     =>      strtoupper(@$foundationData['departmentID']),
            //  config('foundation.staff.department_name')                   =>      @$foundationData['departmentName'],
            config('foundation.staff.group_id')                          =>      strtoupper(@$foundationData['groupID']),
            // config('foundation.staff.group_name')                        =>      @$foundationData['groupName'],
            config('foundation.staff.position_id')                       =>      strtoupper(@$foundationData['positionID']),
            // config('foundation.staff.position_name')                     =>      @$foundationData['positionName'],
            config('foundation.staff.identity_card_number')              =>      @$foundationData['ssn'],
            config('foundation.staff.dob')                               =>      date("Y-m-d",strtotime(@$foundationData['dob'])),
            config('foundation.staff.address1')                          =>      @$foundationData['address'],
            config('foundation.staff.phone_number')                      =>      @$foundationData['personalMobile'],
            config('foundation.staff.emergency_contact')                 =>      @$foundationData['emergencyContact'],
            config('foundation.staff.emergency_contact_phone_number')    =>      @$foundationData['emergencyTel'],
            config('foundation.staff.position_status')                   =>      @$foundationData['positionStatus'],
            config('foundation.staff.hired_date')                        =>      date("Y-m-d",strtotime(@$foundationData['hiredDate'])),
            config('foundation.staff.terminated_date')                   =>      date("Y-m-d",strtotime(@$foundationData['terminatedDate'])),
            config('foundation.staff.country_code')		                 =>	     2,
            config('foundation.staff.company_id')		                 =>	     @$foundationData['companyId'],
            config('foundation.staff.company_name')		                 =>	     @$foundationData['companyName'],
            config('foundation.staff.location_description')		         =>	     @$foundationData['locationDescription'],
            config('foundation.staff.driver_code')		                 =>	     @$foundationData['driverCode'],
            config('foundation.staff.badge')		                     =>	     @$foundationData['badge'],
        ];

        unset($dataOut['']);

        return $dataOut;
    }

    public static function toUserUpdateModel($foundationData)
    {
        $dataOut = [
            config('foundation.staff.id')	                            =>	    strtoupper(@$foundationData['staffID']),
            config('foundation.staff.user_name')	                        =>	    @$foundationData['userName'],
            config('foundation.staff.user_id')	                        =>	    strtoupper(@$foundationData['userID'])
        ];

        unset($dataOut['']);

        return $dataOut;
    }


    public static function addStaffUnitName($unit)
    {
        if($unit[config('foundation.unit.type')] == 8)
        {
            return [config('foundation.staff.company_name')  =>  $unit[config('foundation.unit.name')]];
        }

        if($unit[config('foundation.unit.type')] == 4)
        {
            return [config('foundation.staff.department_name')  =>  $unit[config('foundation.unit.name')]];
        }

        if($unit[config('foundation.unit.type')] == 2)
        {
            return [config('foundation.staff.group_name')  =>  $unit[config('foundation.unit.name')]];
        }

        return null;
    }
}