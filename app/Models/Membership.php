<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    protected $fillable = [
        'membership_name',
        'membership_price',
        'discount_percent',
        'membership_period',
        'membership_description',
        'membership_features',
        'membership_benefits',
        'popular'
    ];

    public function createMembership($request)
    {
        $membership = new Membership();
        $membership->membership_name = $request->membership_name;
        $membership->membership_price = $request->membership_price;
        $membership->discount_percent = $request->discount_percent ?? 0;
        $membership->membership_period = $request->membership_period;
        $membership->membership_description = $request->membership_description;
        $membership->membership_features = $request->membership_features;
        $membership->membership_benefits = $request->membership_benefits;
        return  $membership->save();
    }

    public function updateMembership($request,$id)
    {
        $membership = Membership::findOrFail($request->id);

        $membership->membership_name = $request->membership_name;
        $membership->membership_price = $request->membership_price;
        $membership->discount_percent = $request->discount_percent ?? 0;
        $membership->membership_period = $request->membership_period;
        $membership->membership_description = $request->membership_description;
        $membership->membership_features = $request->membership_features;
        $membership->membership_benefits = $request->membership_benefits;
        return  $membership->save();
    }

    public function makePopular($id, $popular_value)
    {
        $membership =  Membership::findOrFail($id);
        $membership->popular = $popular_value;
        $membership->update();
        return true;
    }

}
