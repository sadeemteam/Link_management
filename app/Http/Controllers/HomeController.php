<?php

namespace App\Http\Controllers;

use App\Models\AppSection;
use App\Models\PricingPlan;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;




class HomeController extends Controller
{
    public function Home(Request $request)
    {
        $plans = PricingPlan::where('status', 'active')->get();
        $appSections = AppSection::all();
        $testimonials = Testimonial::all();

        return view('pages.home', compact('plans', 'appSections', 'testimonials'));
    }


    //-------------------------------------------------
    // Section edit or update of home page
    public function EditHomeSection(Request $req, $sectionId)
    {
        $thumbnail = $req->new_thumbnail;
        $section_title = ucfirst($req->section_title);

        if ($thumbnail) {
            $rules = [
                'section_title' => 'required',
                'new_thumbnail' => 'image|mimes:jpg,png,jpeg|max:5120',
            ];
            $messages = [
                'section_title.required' => 'Section Title is require',
                'new_thumbnail.mimes' => 'Allow only jpg,png,jpeg type image',
                'new_thumbnail.max' => 'Image size will be 5MB',
            ];
            $this->validate($req, $rules, $messages);
            $image = explode("/", $req->current_thumbnail);
            if ($image[0] != 'assets') {
                File::delete($req->current_thumbnail);
            }

            $location = public_path('/upload/');
            $image = Image::make($thumbnail);
            $image->save($location . time() . $thumbnail->getClientOriginalName());
            $imgUrl = 'upload/' . $image->filename . '.' . $image->extension;

            AppSection::where('id', $sectionId)->update([
                'title' => $section_title,
                'description' => $req->description ? $req->description : null,
                'thumbnail' => $imgUrl,
            ]);
        } else {
            AppSection::where('id', $sectionId)->update([
                'title' => $section_title,
                'description' => $req->description ? $req->description : null,
            ]);
        }

        return back();
    }
    //-------------------------------------------------


    //-------------------------------------------------
    // Section edit or update of home page
    public function EditSectionList(Request $req, $sectionId)
    {
        $oneList = ['content' => '', 'icon' => '', 'url' => ''];
        $allList = [];

        for ($i = 1; $i <= count($req->all()) - 2; $i++) {

            foreach ($req->all() as $key => $value) {
                if ($key != '_token' && $key != '_method') {
                    $str = substr($key, -1);
                    $newKey = substr($key, 0, -1);
                    $number =  (int) $str;

                    if ($i == $number) {
                        $oneList[$newKey] = $value;
                    }
                }
            }

            if ($oneList['content'] == '' && $oneList['icon'] == '' && $oneList['url'] == '') {
                break;
            } else {
                array_push($allList, $oneList);
                $oneList = ['content' => '', 'icon' => '', 'url' => ''];
            }
        }

        AppSection::where('id', $sectionId)->update([
            'section_list' => json_encode($allList)
        ]);

        return back();
    }
    //-------------------------------------------------
}
