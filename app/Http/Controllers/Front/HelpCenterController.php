<?php 
namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class HelpCenterController extends Controller
{
    public function helpcenter()
    {
        return view('front.pages.help-center');
    }
}      
