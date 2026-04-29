<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WebSetting;
use App\Models\ContentManagement;
use Validator;

class ContentManagementController extends Controller
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
        //Get web setting data
        $webSettingData = WebSetting::first();

        //Get page content
        $homePageContent = ContentManagement::where('page_name', 'home_page')->first();
        $aboutPageContent = ContentManagement::where('page_name', 'about_page')->first();
        $vitalBoostPageContent = ContentManagement::where('page_name', 'vital_boost_page')->first();
        $collaboratorPageContent = ContentManagement::where('page_name', 'collaborator_page')->first();
        $testimonialPageContent = ContentManagement::where('page_name', 'testimonial_page')->first();
        $faqPageContent = ContentManagement::where('page_name', 'faq_page')->first();
        $callToActionPageContent = ContentManagement::where('page_name', 'call_to_action_page')->first();
        
        return view('admin.content_management.index', compact('webSettingData','homePageContent', 'aboutPageContent', 'vitalBoostPageContent', 'collaboratorPageContent', 'testimonialPageContent', 'faqPageContent', 'callToActionPageContent'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request->form_name == 'general_settings'){
            //Create array of site setting info start
            $data       = [
                'tagline'      => !empty($request->tagline)?$request->tagline:'',
                'footer_text'  => !empty($request->footer_text)?$request->footer_text:'',
            ];

            //Upload logo
            $logoImageName = null;
            if ($request->hasFile('logo') && !empty($request->logo)) {
                $logoImageName = 'logo_'.time() . '.' . $request->logo->getClientOriginalExtension();
                $request->logo->move(public_path('uploads'), $logoImageName);
            }
            $data['logo'] = $logoImageName;

            //Upload favicon
            $faviconImageName = null;
            if ($request->hasFile('favicon') && !empty($request->favicon)) {
                $faviconImageName = 'favicon_'.time() . '.' . $request->favicon->getClientOriginalExtension();
                $request->favicon->move(public_path('uploads'), $faviconImageName);
            }
            $data['favicon'] = $faviconImageName;

            //Create array of site setting info end
        }else if($request->form_name == 'social_media_links'){
            //Create array of socila media links start
            $data       = [
                'facebook_url'      => !empty($request->facebook_url)?$request->facebook_url:'',
                'twitter_url'  => !empty($request->twitter_url)?$request->twitter_url:'',
                'instagram_url'  => !empty($request->instagram_url)?$request->instagram_url:'',
                'youtube_url'  => !empty($request->youtube_url)?$request->youtube_url:''
            ];
            //Create array of social media links end
        }else if($request->form_name == 'seo_meta_settings'){
            //Create array of seo&meta info start
            $data       = [
                'meta_title'      => !empty($request->meta_title)?$request->meta_title:'',
                'meta_description'  => !empty($request->meta_description)?$request->meta_description:'',
                //'og_image'  => !empty($request->og_image)?$request->og_image:''
            ];

            //Upload og image
            $ogImageName = null;
            if ($request->hasFile('og_image') && !empty($request->og_image)) {
                $ogImageName = 'og_image_'.time() . '.' . $request->og_image->getClientOriginalExtension();
                $request->og_image->move(public_path('uploads'), $ogImageName);
            }
            $data['og_image'] = $ogImageName;
            //Create array of seo&meta info end
        }else{
            $data       = [
                'page_name' => !empty($request->form_name)?$request->form_name:'',
                'page_content'      => !empty($request->page_content)?$request->page_content:''
            ];
        } 

        //Validate site setting info start here
        $id = 0;
        $validator = $this->validateData($data, $id, $request->form_name);
        if ($validator->fails()) {
            /*$result = array(
                'status' => $this->status['error']['status'],
                'errortrue' =>  $this->status['error']['errortrue'],
                'message'=> $validator->errors()
            );
            return redirect('admin/content/management')->with('error', $result['message']->first());*/
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }
        //Validate site setting info end here

        //Store site setting data in database start
        if($request->form_name == 'general_settings'){
            $setting_id = WebSetting::saveSiteSetting($data);
            return redirect('admin/content/management')->with('success', 'General Setting has been added successfully.');
        }else if($request->form_name == 'social_media_links'){
            $setting_id = WebSetting::saveSiteSetting($data);
            return redirect('admin/content/management')->with('success', 'Social Media Links has been added successfully.');
        }else if($request->form_name == 'seo_meta_settings'){
            $setting_id = WebSetting::saveSiteSetting($data);
            return redirect('admin/content/management')->with('success', 'Meta Settings has been added successfully.');
        }else{
            ContentManagement::savePageContent($data);
            return redirect('admin/content/management')->with('success', 'Page content has been added successfully.');
        } 
        //Store site setting data in database end
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
    public function update(Request $request, string $id)
    {
        //
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
    public function validateData($data=[], int $id=null, $form_name=null){
        if($form_name == 'general_settings'){
            $response = Validator::make(
                [
                    'tagline'      =>  $data['tagline'],
                    'footer_text'  =>  $data['footer_text'],
                    //'logo'   =>  $data['logo'],
                    //'favicon'  =>  $data['favicon']
                ],
                [
                    'tagline'  =>  'required|string',
                    'footer_text'  =>  'required|string',
                    //'logo'  =>  'required|string',
                    //'favicon'  =>  'required|string'
                ]
            );
        }else if($form_name == 'social_media_links'){
            $response = Validator::make(
                [
                    'facebook_url'      =>  $data['facebook_url'],
                    'twitter_url'  =>  $data['twitter_url'],
                    'instagram_url'  =>  $data['instagram_url'],
                    'youtube_url'  =>  $data['youtube_url']
                ],
                [
                    'facebook_url'  =>  'required|string',
                    'twitter_url'  =>  'required|string',
                    'instagram_url'  =>  'required|string',
                    'youtube_url'  =>  'required|string'
                ]
            );
        }else if($form_name == 'seo_meta_settings'){
            $response = Validator::make(
                [
                    'meta_title'      =>  $data['meta_title'],
                    'meta_description'  =>  $data['meta_description'],
                    //'og_image'  =>  $data['og_image']
                ],
                [
                    'meta_title'  =>  'required|string',
                    'meta_description'  =>  'required|string',
                    //'og_image'  =>  'required|string'
                ]
            );
        }else{
            $response = Validator::make(
                [
                    'page_content'      =>  $data['page_content']
                ],
                [
                    'page_content'  =>  'required|string'
                ]
            );
        }
        return $response;
    }

    public function updateSiteSettings(Request $request){
        if($request->form_name == 'general_settings'){
            //Create array of site setting info start
            $data       = [
                'tagline'      => !empty($request->tagline)?$request->tagline:'',
                'footer_text'  => !empty($request->footer_text)?$request->footer_text:'',
                //'logo'  => !empty($request->logo)?$request->logo:'',
                //'favicon'  => !empty($request->favicon)?$request->favicon:''
            ];

            //Upload logo
            $logoImageName = null;
            if ($request->hasFile('logo') && !empty($request->logo)) {
                $logoImageName = 'logo_'.time() . '.' . $request->logo->getClientOriginalExtension();
                $request->logo->move(public_path('uploads'), $logoImageName);
                $data['logo'] = $logoImageName;
            }
            
            //Upload favicon
            $faviconImageName = null;
            if ($request->hasFile('favicon') && !empty($request->favicon)) {
                $faviconImageName = 'favicon_'.time() . '.' . $request->favicon->getClientOriginalExtension();
                $request->favicon->move(public_path('uploads'), $faviconImageName);
                $data['favicon'] = $faviconImageName;
            }

            //Create array of site setting info end
        }else if($request->form_name == 'social_media_links'){
            //Create array of socila media links start
            $data       = [
                'facebook_url'      => !empty($request->facebook_url)?$request->facebook_url:'',
                'twitter_url'  => !empty($request->twitter_url)?$request->twitter_url:'',
                'instagram_url'  => !empty($request->instagram_url)?$request->instagram_url:'',
                'youtube_url'  => !empty($request->youtube_url)?$request->youtube_url:''
            ];
            //Create array of social media links end
        }else if($request->form_name == 'seo_meta_settings'){
            //Create array of seo&meta info start
            $data       = [
                'meta_title'      => !empty($request->meta_title)?$request->meta_title:'',
                'meta_description'  => !empty($request->meta_description)?$request->meta_description:'',
                //'og_image'  => !empty($request->og_image)?$request->og_image:''
            ];

            //Upload og image
            $ogImageName = null;
            if ($request->hasFile('og_image') && !empty($request->og_image)) {
                $ogImageName = 'og_image_'.time() . '.' . $request->og_image->getClientOriginalExtension();
                $request->og_image->move(public_path('uploads'), $ogImageName);
                $data['og_image'] = $ogImageName;
            }
            //Create array of seo&meta info end
        }else{
            $data = [
                'page_content' => !empty($request->page_content)?$request->page_content:''
            ];
        } 

        //Validate site setting info start here
        $id = isset($request->id)?$request->id:0;
        $validator = $this->validateData($data, $id, $request->form_name);
        if ($validator->fails()) {
            /*$result = array(
                'status' => $this->status['error']['status'],
                'errortrue' =>  $this->status['error']['errortrue'],
                'message'=> $validator->errors()
            );
            return response()->json($result);*/
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }
        //Validate site setting info end here

        //Update site setting by ID start
        $siteSettingUpdateData = $this->getSiteSettingData($data, $id, $request->form_name);
        if($request->form_name == 'general_settings'){
            $update = WebSetting::updateSiteSettingByID($id, $siteSettingUpdateData);
        }else if($request->form_name == 'social_media_links'){
            $update = WebSetting::updateSiteSettingByID($id, $siteSettingUpdateData);
        }else if($request->form_name == 'seo_meta_settings'){
            $update = WebSetting::updateSiteSettingByID($id, $siteSettingUpdateData);
        }else{
            $update = ContentManagement::updatePageContentByID($id, $siteSettingUpdateData);
        }
        //Update site setting by ID end

        if (!empty($update)) {
            if($request->form_name == 'general_settings'){
                return redirect('admin/content/management')->with('success', 'General Settings has been updated successfully.');   
            }else if($request->form_name == 'social_media_links'){
                return redirect('admin/content/management')->with('success', 'Social Media Links has been updated successfully.');
            }else if($request->form_name == 'seo_meta_settings'){
                return redirect('admin/content/management')->with('success', 'SEO & Meta Info has been updated successfully.');
            }else{
                return redirect('admin/content/management')->with('success', 'Page Content has been updated successfully.');
            }
        } else {
            if($request->form_name == 'general_settings'){
                return redirect('admin/content/management')->with('error', 'Unable to update general settings.Please try again...!!!');  
            }else if($request->form_name == 'social_media_links'){
                return redirect('admin/content/management')->with('error', 'Unable to update social media links.Please try again...!!!');
            }else if($request->form_name == 'seo_meta_settings'){
                return redirect('admin/content/management')->with('error', 'Unable to update SEO & Meta Info.Please try again...!!!');
            }else{
                return redirect('admin/content/management')->with('error', 'Unable to update page content.Please try again...!!!');
            }
        }
    }

    /**
     * Get Site Setting data.
     *
     * @param ContentManagementController $siteSettingData comment about this variable
     * @param ContentManagementController $id comment about this variable
     *
     * @return array
     */
    public function getSiteSettingData($siteSettingData=[], int $id=null, $form_name=null){
        if($form_name == 'general_settings'){
            $storeSiteSettingData = [
                'tagline'      => !empty($siteSettingData['tagline'])?$siteSettingData['tagline']:'',
                'footer_text'  => !empty($siteSettingData['footer_text'])?$siteSettingData['footer_text']:'',
                'logo'  => !empty($siteSettingData['logo'])?$siteSettingData['logo']:'',
                'favicon'  => !empty($siteSettingData['favicon'])?$siteSettingData['favicon']:''
            ];
        }else if($form_name == 'social_media_links'){
            $storeSiteSettingData = [
                'facebook_url'      =>  $siteSettingData['facebook_url'],
                'twitter_url'  =>  $siteSettingData['twitter_url'],
                'instagram_url'   =>  $siteSettingData['instagram_url'],
                'youtube_url'  =>  $siteSettingData['youtube_url']
            ];
        }else if($form_name == 'seo_meta_settings'){
            $storeSiteSettingData = [
                'meta_title'      =>  $siteSettingData['meta_title'],
                'meta_description'  =>  $siteSettingData['meta_description'],
                'og_image'  =>  $siteSettingData['og_image']
            ];
        }else{
            $storeSiteSettingData = [
                'page_content' =>  $siteSettingData['page_content']
            ];
        }
        return $storeSiteSettingData;
    }

}