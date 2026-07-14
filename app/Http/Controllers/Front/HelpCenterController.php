<?php 
namespace App\Http\Controllers\Front;
use App\Models\HelpCategory;
use App\Models\ContactOption;
use App\Models\PageContent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class HelpCenterController extends Controller
{
    public function helpcenter()
    {
        $helpTopics = HelpCategory::with([
            'articles' => function($q){
                $q->limit(5);
            }
        ])->get();

        $contactOptions = ContactOption::all();
        $sections = PageContent::sections('help_center');

        return view(
            'front.pages.help-center',
            compact('helpTopics', 'contactOptions', 'sections')
        );
    }
    
}