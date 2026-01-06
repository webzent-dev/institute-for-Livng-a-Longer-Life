<?php 
namespace App\Http\Controllers\Front;
use App\Models\HelpCategory;
use App\Models\ContactOption;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class HelpCenterController extends Controller
{
    // Display Help Center Page
    public function helpcenter()
    {
        $helpTopics = HelpCategory::with(['articles' => function ($q) {
            $q->limit(5);
        }])->get();
         $contactOptions = ContactOption::all();
        return view('front.pages.help-center', compact('helpTopics', 'contactOptions'));
    }
}