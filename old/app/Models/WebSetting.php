<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebSetting extends Model
{
    protected $fillable = [
        'tagline',
        'footer_text',
        'logo',
        'favicon',
        'facebook_url',
        'twitter_url',
        'instagram_url',
        'youtube_url',
        'meta_title',
        'meta_description',
        'og_image'
    ];

    /**
     * Store site setting in our database.
     *
     * @param SiteSetting $data comment about this variable
     * 
     * @return \Illuminate\Http\Response
     */
    public static function saveSiteSetting($data=[])
    {
        $insertID = WebSetting::insertGetId($data);
        return (int)$insertID;
    }

    /**
     * Retrieve the general setting data from the database.
     *
     * @return \App\Models\WebSetting|null
     */
    public static function getSiteSettingData(){
        $siteSettingDetail = WebSetting::first();
        return $siteSettingDetail;
    }   

    /**
     * Update site setting by id.
     *
     * @param WebSetting $id   comment about this variable
     * @param WebSetting $data comment about this variable
     *
     * @return \Illuminate\Http\Response
     */
    public static function updateSiteSettingByID(int $id=null,$data=[])
    {
        $siteSettingDetail = WebSetting::where('id', $id)
        ->update($data);
        if ($siteSettingDetail) {
            return 1;
        } else {
            return 0;
        }
    }
}