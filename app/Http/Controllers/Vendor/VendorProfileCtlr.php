<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Utils\HttpMethodUtil;
use App\Utils\JsonUtil;
use App\Utils\RegexUtil;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendorProfileCtlr extends Controller
{
    private $vendor;
    public function __construct()
    {
        $this->vendor = new Vendor();
    }
    public function index(Request $request)
    {

        $action = $request->get('action') ?? '';
        switch ($action) {
            case 'vendor-timing':
                return $this->vendorTiming($request);
                break;
            case 'profile':
                return $this->vendorProfile($request);
                break;
            case 'add-bank-details':
                return $this->bankDetails($request);
                break;
            case 'vendor-block-date':
                return $this->addDatesForBlock($request);
                break;
            case 'delete-block-date':
                return $this->deleteBlockDate($request);
                break;
            default:
                return abort(404);
        }
    }

    public function vendorTiming(Request $request)
    {
        if (HttpMethodUtil::isMethodGet()) {
            // dd($this->vendor->vendorTiming($request->session()->get('vendor_id')));
            return view('vendor.vendor-timing.index')->with([
                'currentPage' => 'vendor_timing',
                'vendorTiming' => $this->vendor->vendorTiming($request->session()->get('vendor_id')) ?? null,
            ]);
        } elseif (HttpMethodUtil::isMethodPost()) {
            $mondayOpening = $request->get('mondayOpening') ?? '';
            $mondayClosing = $request->get('mondayClosing') ?? '';
            $tuesdayOpening = $request->get('tuesdayOpening') ?? '';
            $tuesdayClosing = $request->get('tuesdayClosing') ?? '';
            $wednesdayOpening = $request->get('wednesdayOpening') ?? '';
            $wednesdayClosing = $request->get('wednesdayClosing') ?? '';
            $thursdayOpening = $request->get('thursdayOpening') ?? '';
            $thursdayClosing = $request->get('thursdayClosing') ?? '';
            $fridayOpening = $request->get('fridayOpening') ?? '';
            $fridayClosing = $request->get('fridayClosing') ?? '';
            $saturdayOpening = $request->get('saturdayOpening') ?? '';
            $saturdayClosing = $request->get('saturdayClosing') ?? '';
            $sundayOpening = $request->get('sundayOpening') ?? '';
            $sundayClosing = $request->get('sundayClosing') ?? '';




            if (empty($mondayOpening)) {
                return JsonUtil::getResponse(false, "Monday opening timing is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if (empty($mondayClosing)) {
                return JsonUtil::getResponse(false, "Monday closing timing is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } elseif ($mondayOpening == $mondayClosing) {
                return JsonUtil::getResponse(false, "Monday opening time and closing timing cannot be same!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } elseif ($mondayOpening > $mondayClosing) {
                return JsonUtil::getResponse(false, "Monday opening time cannot be greater than monday closing time!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if (empty($tuesdayOpening)) {
                return JsonUtil::getResponse(false, "Tuesday opening timing is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if (empty($tuesdayClosing)) {
                return JsonUtil::getResponse(false, "Tuesday closing timing is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } elseif ($tuesdayOpening == $tuesdayClosing) {
                return JsonUtil::getResponse(false, "Tuesday opening time and closing timing cannot be same!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } elseif ($tuesdayOpening > $tuesdayClosing) {
                return JsonUtil::getResponse(false, "Tuesday opening time cannot be greater than tuesday closing time!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if (empty($wednesdayOpening)) {
                return JsonUtil::getResponse(false, "Wednesday opening timing is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if (empty($wednesdayClosing)) {
                return JsonUtil::getResponse(false, "Wednesday closing timing is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } elseif ($wednesdayOpening == $wednesdayClosing) {
                return JsonUtil::getResponse(false, "Wednesday opening time and closing timing cannot be same!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } elseif ($wednesdayOpening > $wednesdayClosing) {
                return JsonUtil::getResponse(false, "Wednesday opening time cannot be greater than wednesday closing time!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if (empty($thursdayOpening)) {
                return JsonUtil::getResponse(false, "Thursday opening timing is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if (empty($thursdayClosing)) {
                return JsonUtil::getResponse(false, "Thursday closing timing is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } elseif ($thursdayOpening == $thursdayClosing) {
                return JsonUtil::getResponse(false, "Thursday opening time and closing timing cannot be same!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } elseif ($thursdayOpening > $thursdayClosing) {
                return JsonUtil::getResponse(false, "Thursday opening time cannot be greater than thursday closing time!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if (empty($fridayOpening)) {
                return JsonUtil::getResponse(false, "Friday opening timing is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if (empty($fridayClosing)) {
                return JsonUtil::getResponse(false, "Friday closing timing is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } elseif ($fridayOpening == $fridayClosing) {
                return JsonUtil::getResponse(false, "Friday opening time and closing timing cannot be same!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } elseif ($fridayOpening > $fridayClosing) {
                return JsonUtil::getResponse(false, "Friday opening time cannot be greater than friday closing time!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if (empty($saturdayOpening)) {
                return JsonUtil::getResponse(false, "Saturday opening timing is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if (empty($saturdayClosing)) {
                return JsonUtil::getResponse(false, "Saturday closing timing is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } elseif ($saturdayOpening == $saturdayClosing) {
                return JsonUtil::getResponse(false, "Saturday opening time and closing timing cannot be same!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } elseif ($saturdayOpening > $saturdayClosing) {
                return JsonUtil::getResponse(false, "Saturday opening time cannot be greater than saturday closing time!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }
            if (empty($sundayOpening)) {
                return JsonUtil::getResponse(false, "Saturday opening timing is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if (empty($sundayClosing)) {
                return JsonUtil::getResponse(false, "Sunday closing timing is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } elseif ($sundayOpening == $sundayClosing) {
                return JsonUtil::getResponse(false, "Sunday opening time and closing timing cannot be same!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } elseif ($sundayOpening > $sundayClosing) {
                return JsonUtil::getResponse(false, "Sunday opening time cannot be greater than sunday closing time!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            try {

                if ($this->vendor->isVendorAlreadyHaveSchedule($request->session()->get('vendor_id'))) {
                    $time = now();
                } else {
                    $time = 'NULL';
                }

                $data = [
                    'vendor_id' => $request->session()->get('vendor_id'),
                    'monday_opening' => $mondayOpening,
                    'monday_closing' => $mondayClosing,
                    'tuesday_opening' => $tuesdayOpening,
                    'tuesday_closing' => $tuesdayClosing,
                    'wednesday_opening' => $wednesdayOpening,
                    'wednesday_closing' => $wednesdayClosing,
                    'thursday_opening' => $thursdayOpening,
                    'thursday_closing' => $thursdayClosing,
                    'friday_opening' => $fridayOpening,
                    'friday_closing' => $fridayClosing,
                    'saturday_opening' => $saturdayOpening,
                    'saturday_closing' => $saturdayClosing,
                    'sunday_opening' => $sundayOpening,
                    'sunday_closing' => $sundayClosing,
                    'created_at' => now(),
                    'updated_at' => $time,
                ];

                if ($this->vendor->isVendorAlreadyHaveSchedule($request->session()->get('vendor_id'))) {
                    $this->vendor->updateSchedule($request->session()->get('vendor_id'), $data);
                    return JsonUtil::getResponse(true, "Schedule is successfully updated!", JsonUtil::$_STATUS_OK);
                } else {
                    $this->vendor->addSchedule($data);
                    return JsonUtil::getResponse(true, "Schedule is successfully added!", JsonUtil::$_STATUS_OK);
                }
            } catch (Exception $e) {
                return JsonUtil::getResponse(false, $e->getMessage(), JsonUtil::$_UNPROCESSABLE_ENTITY);
            }
        }
    }

    public function vendorProfile(Request $request)
    {
        if (HttpMethodUtil::isMethodGet()) {
            $vendorId = $request->session()->get('vendor_id');
            $data = $this->vendor->getVendorDetailsByVendorId($vendorId);
            return view('vendor.vendor-profile')->with([
                'currentPage' => 'vendorProfile',
                'id' => $vendorId,
                'data' => $data,
            ]);
        }
    }

    public function bankDetails(Request $request)
    {
        if (HttpMethodUtil::isMethodPost()) {
            $vendorId = $request->session()->get('vendor_id');
            $bankDetails = $request->get('bankDetails') ?? '';

            if (empty($bankDetails)) {
                return JsonUtil::getResponse(false, "Bank details is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } elseif (strlen($bankDetails) > 300) {
                return JsonUtil::getResponse(false, "Please add your bank details in between 300 characters!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            try {
                $this->vendor->editVendor($vendorId, [
                    'bank_details' => $bankDetails,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
                return JsonUtil::getResponse(true, "Oparation is completed successfully!", JsonUtil::$_STATUS_OK);
            } catch (Exception $e) {
                JsonUtil::serverError();
            }
        }
    }

    public function addDatesForBlock(Request $request)
    {
        if (HttpMethodUtil::isMethodGet()) {
            $whereRaw = "1=?";
            $whereParams = [1];
           
            $blockDates = $this->vendor->getBlockDates($request->session()->get('vendor_id'),$whereRaw, $whereParams,20);
           
            return view('vendor.vendor-timing.block-date')->with([
                'currentPage' => 'block_date',
                'dates' =>  $blockDates,
                'sn' => ($blockDates->currentPage() - 1) * $blockDates->perPage(),
            ]);
        } elseif (HttpMethodUtil::isMethodPost()) {
            $flexRadioDefault = $request->get('flexRadioDefault') ?? '';
            $blockDates = $request->get('date') ?? [];
            $startDate = $request->get('startDate') ?? '';
            $endDate = $request->get('endDate') ?? '';
            $data = [];


            if ($flexRadioDefault == '1') {
                
                foreach ($blockDates as $key => $val) {
                    if (empty($blockDates[$key])) {
                        return JsonUtil::getResponse(false, "Please select date on row no "  . $key + 1, JsonUtil::$_UNPROCESSABLE_ENTITY);
                    } elseif (date('Y-m-d') > $blockDates[$key]) {
                        return JsonUtil::getResponse(false, "Past date is not allowed on row no "  . $key + 1, JsonUtil::$_UNPROCESSABLE_ENTITY);
                    } elseif ($this->vendor->isBlockDateIsAlreadyExists($request->session()->get('vendor_id'), $blockDates[$key])) {
                        return JsonUtil::getResponse(false, "This date is already exists on row no " . $key + 1, JsonUtil::$_UNPROCESSABLE_ENTITY);
                    }

                    $val = [
                        'vendor_id' => $request->session()->get('vendor_id'),
                        'block_date' => $blockDates[$key],
                        'start_date_range' => null,
                        'end_date_range' => null,
                        'created_at' => date('Y-m-d H:i:s'),
                        'created_by' => $request->session()->get('vendor_id'),
                    ];

                    array_push($data, $val);
                }

                DB::beginTransaction();
                try {
                    $isOrAre = count($data) > 1 ? 'are' : 'is';
               
                    $this->vendor->addBlockDates($data);
                    DB::commit();
                    return JsonUtil::getResponse(true, "Closing dates " . $isOrAre .  " added successfully!", JsonUtil::$_STATUS_OK);
                } catch (Exception $e) {
                    DB::rollBack();
                    return JsonUtil::getResponse(false, $e->getMessage(), JsonUtil::$_UNPROCESSABLE_ENTITY);
                }
            }elseif($flexRadioDefault == '2'){
                // dd(1);
                if(empty($startDate)){
                    return JsonUtil::getResponse(false,"Start date is required!",JsonUtil::$_UNPROCESSABLE_ENTITY);
                }
                if(empty($endDate)){
                    return JsonUtil::getResponse(false,"Start date is required!",JsonUtil::$_UNPROCESSABLE_ENTITY);
                }elseif($endDate <= $startDate){
                    return JsonUtil::getResponse(false,"End date should be greater than start date!",JsonUtil::$_UNPROCESSABLE_ENTITY); 
                }

               $array = $this->getBetweenDates($startDate,$endDate);
               $dateArray = [];
               foreach($array as $a){
                $data = [
                    'vendor_id' => $request->session()->get('vendor_id'),
                    'dates' => $a,
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => $request->session()->get('vendor_id')
                ];
                array_push($dateArray,$data);
               }
            //    dd($dateArray);
               DB::beginTransaction();
               try{
                $this->vendor->insertDatesFromRange($dateArray);
                $this->vendor->addBlockDates([
                    'vendor_id' => $request->session()->get('vendor_id'),
                    'block_date' => null,
                    'start_date_range' => $startDate,
                    'end_date_range' => $endDate,
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => $request->session()->get('vendor_id')
                ]);
                DB::commit();
                return JsonUtil::getResponse(true, "Date range added successfully!",JsonUtil::$_STATUS_OK);
               }catch(Exception $e){
                DB::rollBack();
                return JsonUtil::getResponse(false,$e->getMessage(),JsonUtil::$_UNPROCESSABLE_ENTITY);
               }
            }
        }
    }

    public function getBetweenDates($startDate,$endDate)
    {
            $rangArray = [];
         
            $startDate = strtotime($startDate);
            $endDate = strtotime($endDate);
         
            for ($currentDate = $startDate; $currentDate <= $endDate; $currentDate += (86400)) {
                $date = date('Y-m-d', $currentDate);
                $rangArray[] = $date;
            }
         
            return $rangArray;
        
    }

    public function deleteBlockDate(Request $request)
    {
        if(HttpMethodUtil::isMethodPost()){
            
            $dateId = $request->get('dateId') ?? '';
            if(empty($dateId) || !RegexUtil::isNumeric($dateId)){
                return JsonUtil::getResponse(false,"Invalid Id",JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            try{
                $this->vendor->deleteBlockDate($dateId);
                return JsonUtil::getResponse(true,"Date deleted successfully!",JsonUtil::$_STATUS_OK);
            }catch(Exception $e){
                JsonUtil::serverError();
            }
        }
    }
}
