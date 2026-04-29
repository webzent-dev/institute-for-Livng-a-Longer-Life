<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Location extends Model
{
    protected $fillable = [
        'name',
        'city',
        'state',
        'zip',
        'country',
        'address',
        'phone',
        'email',
        'latitude',
        'longitude',
    ];
}
