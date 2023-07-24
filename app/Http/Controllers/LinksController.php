<?php
namespace App\Http\Controllers;

use App\Models\AppSetting;
use Illuminate\Http\Request;
use App\Models\Link;
use App\Models\Theme;
use App\Models\QRCode;
use App\Models\Language;
use App\Models\CustomTheme;
use App\Models\LinkItem;
use App\Models\PricingPlan;
use App\Models\ShetabitVisit;
use App\Rules\CheckLinkName;
use Illuminate\Support\Facades\File;
use Stevebauman\Location\Facades\Location;
use Intervention\Image\ImageManagerStatic as Image;

class LinksController extends Controller
{
    // Getting the total bio-links of user
    public function BioLinks(Request $req) 
    {
        $linkLimit = 0;
        $user = auth()->user();
        $SA = $user->hasRole('SUPER-ADMIN');
        $plan = PricingPlan::where('id', $user->pricing_plan_id)->first();

        if ($SA) {
            $links = Link::where('link_type', 'biolink')->orderBy('created_at', 'desc')->paginate(10);
            return view('pages.admin.links', compact('links'));

        } else {
            $links = Link::where('user_id', $user->id)->where('link_type', 'biolink')->orderBy('created_at', 'desc')->paginate(10);

            if ($plan->biolinks == 'Unlimited') {
                $limit_over = FALSE;
                return view('pages.links', compact('links', 'limit_over'));
            }

            if ($links->count() >=  intval($plan->biolinks)) {
                $limit_over = TRUE;
                return view('pages.links', compact('links', 'limit_over'));
            } else {
                $limit_over = FALSE;
                return view('pages.links', compact('links', 'limit_over'));
            }
        }
    }
    // -------------------------------------------------


    // Getting the total bio-links of user
    public function GetShortLinks(Request $req) 
    {
        $linkLimit = 0;
        $user = auth()->user();
        $SA = $user->hasRole('SUPER-ADMIN');
        $plan = PricingPlan::where('id', $user->pricing_plan_id)->first();

        if ($SA) {
            $links = Link::where('link_type', 'shortlink')->orderBy('created_at', 'desc')->paginate(10);
            return view('pages.admin.short-links', compact('links'));

        } else {
            $links = Link::where('user_id', $user->id)->where('link_type', 'shortlink')->orderBy('created_at', 'desc')->paginate(10);

            if ($plan->biolinks == 'Unlimited') {
                $limit_over = FALSE;
                return view('pages.short_links', compact('links', 'limit_over'));
            }

            if ($links->count() >=  intval($plan->biolinks)) {
                $limit_over = TRUE;
                return view('pages.short_links', compact('links', 'limit_over'));
            } else {
                $limit_over = FALSE;
                return view('pages.short_links', compact('links', 'limit_over'));
            }
        }
    }
    // -------------------------------------------------
    

    // -------------------------------------------------
    // Creating a new bio-link
    function CreateLink(Request $req) 
    {
        $user = auth()->user();
        $app = AppSetting::get()->first();

        if ($req->link_type == 'shortlink') {
            $req->validate([
                'link_name' => ['required','string','min:5','max:255'],
                'external_url' => 'required|min:1|max:255|url',
            ]);

            $link_key = rand(10000000, 90000000);
            $short_link = base_convert($link_key, 10, 36);

            $link = new Link;
            $link->user_id = $user->id;
            $link->link_name = $req->link_name;
            $link->link_type = $req->link_type;
            $link->url_name = $short_link;
            $link->external_url = $req->external_url;
            $link->save();

        } else {
            $req->validate([
                'link_name' => ['required','string','min:5','max:255'],
                'url_name' => ['required','unique:links','string','min:5','max:255',new CheckLinkName]       
            ]);

            $theme = Theme::get()->first();
            $trimUrl = trim(str_replace(" ","", $req->url_name));
            $urlName = preg_replace("/\s+/", "", strtolower($trimUrl));

            $link = new Link;
            $link->user_id = $user->id;
            $link->link_name = $req->link_name;
            $link->url_name = $urlName;
            $link->theme_id = $theme->id;
            $link->branding = $app->logo;
            $link->save();
        }

        return back()->with('success', 'Link created successfully');
    }
    //--------------------------------------------------


    //----------------------------------------------------
    // Bio-link name or username updating
    public function UpdateLink(Request $req, $linkId) 
    {
        $urlName = preg_replace("/\s+/", "", strtolower($req->url_name));

        if ($req->link_type && $req->link_type == 'shortlink') {

            $rules = ['external_url' => 'required|url'];
            $messages = ['external_url.url' => 'Please provide a valid url.'];
            $this->validate($req, $rules, $messages, );
    
            Link::where('id', $linkId)->update([
                'link_name' => $req->link_name,
                'external_url' => $req->external_url,
            ]);
            
            return back();
            
        } else {
            if ($req->url_name) {
                $rules = ['url_name' => ['unique:links', new CheckLinkName]];
                $messages = ['url_name.unique' => 'URL name already used, please try another.'];
                $this->validate($req, $rules, $messages);
            } else {
                $urlName = sprintf('%04x%04x', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
            }
    
            Link::where('id', $linkId)->update([
                'link_name' => $req->link_name,
                'url_name' => $urlName,
            ]);
            
            return back();
        }
    }
    //--------------------------------------------------


    //----------------------------------------------------
    // Bio-link name or username updating
    public function UpdateLinkLogo(Request $req, $linkId) 
    {
        $res = Link::where('id', $linkId)->update([
            'branding' => $req->branding,
        ]);
        
        return $res;
    }
    //--------------------------------------------------


    //----------------------------------------------------
    //Bio-link profile updating
    public function UpdateLinkProfile (Request $req, $linkId)
    {
        $rules = [
            'link_bio' => 'max:200',
            'thumbnail' => 'image|mimes:jpg,png,jpeg,svg|max:5120',
        ];
        $messages = [
            'link_bio.max' => 'Bio description length must be 1 to 200 characters',
            'thumbnail.image' => 'Allow only jpg,png,jpeg,svg type image',
            'thumbnail.max' => 'Image size will be 5MB',
        ];
        
        $this->validate($req, $rules, $messages, );
        $link = Link::find($linkId);
        $thumbnail = $req->thumbnail;
        
        if ($thumbnail) {
            File::delete($link->thumbnail);

            $location = public_path('/upload/');
            $image = Image::make($thumbnail);
            $image->save($location.time().$thumbnail->getClientOriginalName());
            $imgUrl = 'upload/'.$image->filename.'.'.$image->extension;

            Link::where('id', $linkId)->update([
                'link_name' => $req->link_name,
                'short_bio' => $req->link_bio,
                'thumbnail' => $imgUrl,
            ]);
        } else {
            Link::where('id', $linkId)->update([
                'link_name' => $req->link_name,
                'short_bio' => $req->link_bio,
            ]);
        }
        
        return back();
    }
    //--------------------------------------------------


    //----------------------------------------------------
    // Socials links updating of bio-link
    public function UpdateLinkSocials(Request $req, $linkId) 
    {
        $res = Link::where('id', '=', $linkId)->update([
            'socials' => $req->socials,
        ]);
        
        return $res;
    }
    //--------------------------------------------------


    //----------------------------------------------
    // Delete a bio-link
    function DeleteLink($linkId) 
    {
        $link = Link::find($linkId);
        LinkItem::where('item_link', $link->url_name)->delete();
        if ($link->qrcode_id) {
            QRCode::find($link->qrcode_id)->delete();
        }
        $link->delete();

        return back()->with('success', 'Link deleted successfully');
    }
    //--------------------------------------------------


    //----------------------------------------------
    // Changing the current theme of bio-link
    function ThemeUpdate($themeId, $linkId) {
        $result = Link::where('id', $linkId)->update([
            'theme_id' => $themeId,
            'custom_theme_active' => FALSE,
        ]);

        return $result;
    }
    //--------------------------------------------------


    //----------------------------------------------
    // Creating custom theme for user bio-link
    function AddCustomTheme(Request $req, $linkId)
    {
        $theme = new CustomTheme();
        $theme->link_id = $linkId;
        $theme->background = $req->background;
        $theme->background_type = $req->background_type;
        $theme->text_color = $req->text_color;
        $theme->btn_type = $req->btn_type;
        $theme->btn_transparent = $req->btn_transparent;
        $theme->btn_radius = $req->btn_radius;
        $theme->btn_bg_color = $req->btn_bg_color;
        $theme->btn_text_color = $req->btn_text_color;
        $theme->font_family = $req->font_family;
        $theme->save();

        Link::where('id', $linkId)->update([
            'theme_id' => NULL,
            'custom_theme_id' => $theme->id,
            'custom_theme_active' => TRUE,
        ]);

        return $theme;
    }
    //--------------------------------------------------


    //----------------------------------------------
    // Activating the user custom theme for bio-link
    function ActiveCustomTheme(Request $req, $linkId)
    {
        $res = Link::where('id', $linkId)->update([
            'theme_id' => NULL,
            'custom_theme_active' => TRUE,
        ]);

        return $res;
    }
    //--------------------------------------------------


    //-------------------------------------------
    // Updating the user custom theme
    function UpdateCustomTheme(Request $req, $themeId)
    {
        if ($req->background) {
            $res = CustomTheme::where('id', $themeId)->update([
                'background' => $req->background,
                'background_type' => $req->background_type,
            ]);
            return $res;

        } else if ($req->button) {
            $res = CustomTheme::where('id', $themeId)->update([
                'btn_type' => $req->button,
                'btn_transparent' => $req->btn_transparent,
                'btn_radius' => $req->btn_radius,
                'btn_bg_color' => $req->btn_bg_color,
            ]);
            return $res;

        } else if ($req->btn_bg_color) {
            $res = CustomTheme::where('id', $themeId)->update([
                'btn_bg_color' => $req->btn_bg_color,
            ]);
            return $res;

        } else if ($req->btn_text_color) {
            $res = CustomTheme::where('id', $themeId)->update([
                'btn_text_color' => $req->btn_text_color,
            ]);
            return $res;

        } else if ($req->text_color) {
            $res = CustomTheme::where('id', $themeId)->update([
                'text_color' => $req->text_color,
            ]);
            return $res;

        } else if ($req->font_family) {
            $res = CustomTheme::where('id', $themeId)->update([
                'font_family' => $req->font_family,
            ]);
            return $res;
        };
    }
    //--------------------------------------------------


    //----------------------------------------------
    // Access the main bio-link page
    function GetLink(Request $req, $lastLink)
    {
        $link = Link::where('url_name', $lastLink)->first();
        if ($link) {
            $model = new ShetabitVisit;
            $result = $req->visitor()->visit($model);

            // when app on the live server then ip will be => $req->ip();
            // $location = Location::get("103.146.2.177"); 
            $location = Location::get($req->ip()); 

            ShetabitVisit::where('id', $result->id)->update([
                'ip' => json_encode($location),
                'link_id' => $link->id,
            ]);

            if ($link->link_type == 'shortlink') {
                return redirect()->to(url($link->external_url));
            } else {
                return view('pages.biolink', compact('link'));
            }
        } else {
            abort(404);
        }
    }
    //--------------------------------------------------


    //--------------------------------------------------
    // Bio-link analytics for tracking bio-link
    function BioLinkAnalytics($linkId){
        $languages = Language::get();
        $link = Link::where('id', $linkId)->first();

        $analytics = ShetabitVisit::where('link_id', $link->id)->get();
        
        return view('pages.biolink_analytics', compact('link', 'analytics', 'languages'));
    }
}
