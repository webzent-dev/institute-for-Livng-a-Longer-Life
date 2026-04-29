<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $table = 'site_settings';
    
    protected $fillable = [
        'site_name',
        'site_description',
        'contact_email',
        'smtp_host',
        'smtp_port',
        'session_timeout',
        'created_at',
        'updated_at'
    ];

    /**
     * Store general setting in our database.
     *
     * @param SiteSetting $data comment about this variable
     * 
     * @return \Illuminate\Http\Response
     */
    public static function saveGeneralSetting($data=[])
    {
        $insertID = SiteSetting::insertGetId($data);
        return (int)$insertID;
    }

    /**
     * Retrieve the general setting data from the database.
     *
     * @return \App\Models\SiteSetting|null
     */
    public static function getGeneralSettingData(){
        $generalSettingDetail = SiteSetting::first();
        return $generalSettingDetail;
    }   

    /**
     * Update general setting by id.
     *
     * @param SiteSetting $id   comment about this variable
     * @param SiteSetting $data comment about this variable
     *
     * @return \Illuminate\Http\Response
     */
    public static function updateGeneralSettingByID(int $id=null,$data=[])
    {
        $sitesettingDetail = SiteSetting::where('id', $id)
        ->update($data);
        if ($sitesettingDetail) {
            return 1;
        } else {
            return 0;
        }
    }

}