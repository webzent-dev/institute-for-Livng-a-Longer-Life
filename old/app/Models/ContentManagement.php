<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentManagement extends Model
{
    protected $fillable = ['page_name', 'page_content'];

    /**
     * Store page content in our database.
     *
     * @param ContentManagement $data comment about this variable
     * 
     * @return \Illuminate\Http\Response
     */
    public static function savePageContent($data=[])
    {
        $insertID = ContentManagement::insertGetId($data);
        return (int)$insertID;
    }

    /**
     * Update page content by id.
     *
     * @param ContentManagement $id   comment about this variable
     * @param ContentManagement $data comment about this variable
     *
     * @return \Illuminate\Http\Response
     */
    public static function updatePageContentByID(int $id=null,$data=[])
    {
        $pageContentDetail = ContentManagement::where('id', $id)
        ->update($data);
        if ($pageContentDetail) {
            return 1;
        } else {
            return 0;
        }
    }

}
