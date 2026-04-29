<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\SiteSetting;

class SettingsController extends Controller
{
    /**
     * Create $status variable.
     *
     * @return void
     */
    public $status;  
   
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->status = config('constant');
        //$this->adminID = !empty(Session::get('adminId'))?Session::get('adminId'):0;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Get general setting data
        $siteSettingData = SiteSetting::getGeneralSettingData();

        return view('admin.settings.index',compact('siteSettingData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //Get general setting data
        $siteSettingData = SiteSetting::getGeneralSettingData();

        return view('admin.settings.index',compact('siteSettingData'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request->form_name == 'general_setting'){
            //Create array of general setting info start
            $generalSettingData       = [
                'site_name'      => !empty($request->site_name)?$request->site_name:'',
                'site_description'  => !empty($request->site_description)?$request->site_description:'',
                'contact_email'  => !empty($request->contact_email)?$request->contact_email:''
            ];
            //Create array of general setting info end
        }else if($request->form_name == 'email_setting'){
            //Create array of email setting info start
            $generalSettingData       = [
                'smtp_host'      => !empty($request->smtp_host)?$request->smtp_host:'',
                'smtp_port'  => !empty($request->smtp_port)?$request->smtp_port:''
            ];
            //Create array of email setting info end
        }else if($request->form_name == 'stripe_setting'){
            //Create array of stripe setting info start
            $generalSettingData       = [
                'stripe_sandbox_key'      => !empty($request->stripe_sandbox_key)?$request->stripe_sandbox_key:'',
                'stripe_sandbox_secret'  => !empty($request->stripe_sandbox_secret)?$request->stripe_sandbox_secret:'',
                'stripe_production_key'  => !empty($request->stripe_production_key)?$request->stripe_production_key:'',
                'stripe_production_secret'  => !empty($request->stripe_production_secret)?$request->stripe_production_secret:'',
                'stripe_mode'  => !empty($request->stripe_mode)?$request->stripe_mode:'sandbox'
            ];
            //Create array of stripe setting info end
        }else if($request->form_name == 'zoom_setting'){
            //Create array of zoom setting info start
            $generalSettingData       = [
                'zoom_client_id'      => !empty($request->zoom_client_id)?$request->zoom_client_id:'',
                'zoom_client_secret'  => !empty($request->zoom_client_secret)?$request->zoom_client_secret:'',
                'zoom_account_id'  => !empty($request->zoom_account_id)?$request->zoom_account_id:'',
                'zoom_api_url'  => !empty($request->zoom_api_url)?$request->zoom_api_url:''
            ];
            //Create array of zoom setting info end
        }else{
            //Create array of security setting info start
            $generalSettingData       = [
                'session_timeout'      => !empty($request->session_timeout)?$request->session_timeout:''
            ];
            //Create array of security setting info end
        } 

        //Validate general setting info start here
        $id = 0;
        $validator = $this->validateData($generalSettingData, $id, $request->form_name);
        if ($validator->fails()) {
            $result = array(
                'status' => $this->status['error']['status'],
                'errortrue' =>  $this->status['error']['errortrue'],
                'message'=> $validator->errors()
            );
            return response()->json($result);
        }
        //Validate general setting info end here

        //Store general setting data in database start
        $setting_id = SiteSetting::saveGeneralSetting($generalSettingData);
        if($request->form_name == 'general_setting'){
            return redirect('admin/settings')->with('success', 'General Setting has been added successfully.');
        }else if($request->form_name == 'email_setting'){
            return redirect('admin/settings')->with('success', 'Email Setting has been added successfully.');
        }else if($request->form_name == 'stripe_setting'){
            return redirect('admin/settings')->with('success', 'Stripe Setting has been added successfully.');
        }else if($request->form_name == 'zoom_setting'){
            return redirect('admin/settings')->with('success', 'Zoom Setting has been added successfully.');
        }else{
            return redirect('admin/settings')->with('success', 'Security Setting has been added successfully.');
        } 
        //Store general setting data in database end
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    //public function update(Request $request, string $id)
    public function updateGeneralSetting(Request $request)
    {
        //Create array of general setting info start
        if($request->form_name == 'general_setting'){
            $generalSettingData       = [
                'site_name'      => !empty($request->site_name)?$request->site_name:'',
                'site_description'  => !empty($request->site_description)?$request->site_description:'',
                'contact_email'  => !empty($request->contact_email)?$request->contact_email:''
            ];
        }else if($request->form_name == 'email_setting'){
            $generalSettingData       = [
                'smtp_host'      => !empty($request->smtp_host)?$request->smtp_host:'',
                'smtp_port'  => !empty($request->smtp_port)?$request->smtp_port:''
            ];
        }else if($request->form_name == 'stripe_setting'){
            $generalSettingData       = [
                'stripe_sandbox_key'      => !empty($request->stripe_sandbox_key)?$request->stripe_sandbox_key:'',
                'stripe_sandbox_secret'  => !empty($request->stripe_sandbox_secret)?$request->stripe_sandbox_secret:'',
                'stripe_production_key'  => !empty($request->stripe_production_key)?$request->stripe_production_key:'',
                'stripe_production_secret'  => !empty($request->stripe_production_secret)?$request->stripe_production_secret:'',
                'stripe_mode'  => !empty($request->stripe_mode)?$request->stripe_mode:'sandbox'
            ];
        }else if($request->form_name == 'zoom_setting'){
            $generalSettingData       = [
                'zoom_client_id'      => !empty($request->zoom_client_id)?$request->zoom_client_id:'',
                'zoom_client_secret'  => !empty($request->zoom_client_secret)?$request->zoom_client_secret:'',
                'zoom_account_id'  => !empty($request->zoom_account_id)?$request->zoom_account_id:'',
                'zoom_api_url'  => !empty($request->zoom_api_url)?$request->zoom_api_url:''
            ];
        }else{
            $generalSettingData       = [
                'session_timeout'      => !empty($request->session_timeout)?$request->session_timeout:''
            ];
        } 
        //Create array of security setting info end

        $id = !empty($request->id)?$request->id:0;

        //Validate general setting info start here
        $validator = $this->validateData($generalSettingData, $id, $request->form_name);
        if ($validator->fails()) {
            return redirect('admin/settings')
            ->withErrors($validator)
            ->withInput();
        }
        //Validate general setting info end here

        //Update general setting by ID start
        $generalsettingUpdateData = $this->getGeneralSettingData($generalSettingData, $id, $request->form_name);
        $update = SiteSetting::updateGeneralSettingByID($id, $generalsettingUpdateData);
        //Update general setting by ID end

        if (!empty($update)) {
            if($request->form_name == 'general_setting'){
                return redirect('admin/settings')->with('success', 'General Setting has been updated successfully.');   
            }else if($request->form_name == 'email_setting'){
                return redirect('admin/settings')->with('success', 'Email Setting has been updated successfully.');
            }else if($request->form_name == 'stripe_setting'){
                return redirect('admin/settings')->with('success', 'Stripe Setting has been updated successfully.');
            }else if($request->form_name == 'zoom_setting'){
                return redirect('admin/settings')->with('success', 'Zoom Setting has been updated successfully.');
            }else{
                return redirect('admin/settings')->with('success', 'Security Setting has been updated successfully.');
            }
        } else {
            if($request->form_name == 'general_setting'){
                return redirect('admin/settings')->with('error', 'Unable to update general setting.Please try again...!!!');  
            }else if($request->form_name == 'email_setting'){
                return redirect('admin/settings')->with('error', 'Unable to update email setting.Please try again...!!!');
            }else if($request->form_name == 'stripe_setting'){
                return redirect('admin/settings')->with('error', 'Unable to update stripe setting.Please try again...!!!');
            }else if($request->form_name == 'zoom_setting'){
                return redirect('admin/settings')->with('error', 'Unable to update zoom setting.Please try again...!!!');
            }else{
                return redirect('admin/settings')->with('error', 'Unable to update security setting.Please try again...!!!');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Validate General Setting data.
     *
     * @param SettingsController $generalSettingData comment about this variable
     * @param SettingsController $id comment about this variable
     *
     * @return mixed
     */
    public function validateData($generalSettingData=[], int $id=null, $form_name=null){
        if($form_name == 'general_setting'){
            $response = Validator::make(
                [
                    'site_name'      =>  $generalSettingData['site_name'],
                    'site_description'  =>  $generalSettingData['site_description'],
                    'contact_email'   =>  $generalSettingData['contact_email']
                ],
                [
                    'site_name'  =>  'required|string',
                    'site_description'  =>  'required|string',
                    'contact_email'  =>  'required|email'
                ]
            );
        }else if($form_name == 'email_setting'){
            $response = Validator::make(
                [
                    'smtp_host'      =>  $generalSettingData['smtp_host'],
                    'smtp_port'  =>  $generalSettingData['smtp_port']
                ],
                [
                    'smtp_host'  =>  'required|string',
                    'smtp_port'  =>  'required|string'
                ]
            );
        }else if($form_name == 'stripe_setting'){
            $response = Validator::make(
                [
                    'stripe_sandbox_key'      =>  $generalSettingData['stripe_sandbox_key'],
                    'stripe_sandbox_secret'  =>  $generalSettingData['stripe_sandbox_secret'],
                    'stripe_production_key'  =>  $generalSettingData['stripe_production_key'],
                    'stripe_production_secret'  =>  $generalSettingData['stripe_production_secret'],
                    'stripe_mode'  =>  $generalSettingData['stripe_mode']
                ],
                [
                    'stripe_sandbox_key'  =>  'required|string',
                    'stripe_sandbox_secret'  =>  'required|string',
                    'stripe_production_key'  =>  'required|string',
                    'stripe_production_secret'  =>  'required|string',
                    'stripe_mode'  =>  'required|in:sandbox,production'
                ]
            );
        }else if($form_name == 'zoom_setting'){
            $response = Validator::make(
                [
                    'zoom_client_id'      =>  $generalSettingData['zoom_client_id'],
                    'zoom_client_secret'  =>  $generalSettingData['zoom_client_secret'],
                    'zoom_account_id'  =>  $generalSettingData['zoom_account_id'],
                    'zoom_api_url'  =>  $generalSettingData['zoom_api_url']
                ],
                [
                    'zoom_client_id'  =>  'required|string',
                    'zoom_client_secret'  =>  'required|string',
                    'zoom_account_id'  =>  'required|string',
                    'zoom_api_url'  =>  'required|url'
                ]
            );
        }else{
            $response = Validator::make(
                [
                    'session_timeout'      =>  $generalSettingData['session_timeout']
                ],
                [
                    'session_timeout'  =>  'required|integer'
                ]
            );
        }
        return $response;
    }

    /**
     * Get General Setting data.
     *
     * @param SettingsController $generalSettingData comment about this variable
     * @param SettingsController $id comment about this variable
     *
     * @return array
     */
    public function getGeneralSettingData($generalSettingData=[], int $id=null, $form_name=null){
        if($form_name == 'general_setting'){
            $storeGeneralSettingData = [
                'site_name'      =>  $generalSettingData['site_name'],
                'site_description'  =>  $generalSettingData['site_description'],
                'contact_email'   =>  $generalSettingData['contact_email']
            ];
        }else if($form_name == 'email_setting'){
            $storeGeneralSettingData = [
                'smtp_host'      =>  $generalSettingData['smtp_host'],
                'smtp_port'  =>  $generalSettingData['smtp_port']
            ];
        }else if($form_name == 'stripe_setting'){
            $storeGeneralSettingData = [
                'stripe_sandbox_key'      =>  $generalSettingData['stripe_sandbox_key'],
                'stripe_sandbox_secret'  =>  $generalSettingData['stripe_sandbox_secret'],
                'stripe_production_key'  =>  $generalSettingData['stripe_production_key'],
                'stripe_production_secret'  =>  $generalSettingData['stripe_production_secret'],
                'stripe_mode'  =>  $generalSettingData['stripe_mode']
            ];
        }else if($form_name == 'zoom_setting'){
            $storeGeneralSettingData = [
                'zoom_client_id'      =>  $generalSettingData['zoom_client_id'],
                'zoom_client_secret'  =>  $generalSettingData['zoom_client_secret'],
                'zoom_account_id'  =>  $generalSettingData['zoom_account_id'],
                'zoom_api_url'  =>  $generalSettingData['zoom_api_url']
            ];
        }else{
            $storeGeneralSettingData = [
                'session_timeout'      =>  $generalSettingData['session_timeout']
            ];
        }
        return $storeGeneralSettingData;
    }

}