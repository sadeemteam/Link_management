<?php

namespace App\Http\Controllers;
use App\Models\Link;
use App\Models\Theme;
use App\Models\LinkItem;
use App\Models\PricingPlan;
use App\Models\SocialLinks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LinkItemsController extends Controller
{
    //--------------------------------------------------------
    // Getting the user bio-link elements
    function EditBioLink(Request $req, $linkUrl)
    {
        $user = auth()->user();   
        $SA = $user->hasRole('SUPER-ADMIN');
        $themes = Theme::all();
        $socialLinks = SocialLinks::all();
        $link = Link::where('url_name', $linkUrl)->first();
        $itemLastPosition = LinkItem::all()->max('item_position');
        $plan = PricingPlan::where('id', $user->pricing_plan_id)->first();

        if (!$link) {
            abort(404);
        } else if($SA || $link->user_id == $user->id) {
            return view('pages.add_link_items', compact('link', 'plan', 'socialLinks', 'themes', 'itemLastPosition'));
        } else {
            return back();
        }
    }
    //--------------------------------------------------------


    //--------------------------------------------------------
    // Updating the position of bio-link elements when user drag and drop on view.
    function UpdateItemPosition(Request $req){
        $linkItems = $req->input('linkItems');
        $newArr = json_decode(json_encode($linkItems));
        foreach($newArr as $item){
            LinkItem::where('id', '=', $item->id)->update([
                'item_position' => $item->position
            ]);
        }
        return 'success';
    }
    //--------------------------------------------------------


    //--------------------------------------------------------
    // Add new element of bio-link
    public function AddLinkItem(Request $req)
    {
        $user = auth()->user();
        $short_link = NULL;
        
        if ($req->item_type == 'Link' || $req->item_type == 'Embed Link') {
            $rules = ['item_link' => 'required|url'];
            $messages = ['item_link.url' => 'Please provide a valid url'];
            $this->validate($req, $rules, $messages);
        }

        if ($req->item_type == 'Link') {
            $link_key = rand(10000000, 90000000);
            $short_link = base_convert($link_key, 10, 36);

            $link = new Link;
            $link->user_id = $user->id;
            $link->link_name = $req->item_title;
            $link->link_type = 'shortlink';
            $link->url_name = $short_link;
            $link->external_url = $req->item_link;
            $link->save();
        }

        try {
            $item = new LinkItem;
            $item->link_id = $req->link_id;
            $item->item_position = $req->item_position;
            $item->item_type = $req->item_type;
            $item->item_sub_type = $req->item_sub_type;
            $item->item_title = $req->item_title;
            $item->item_link = $short_link ? $short_link : $req->item_link;
            $item->item_icon = $req->item_icon;
            $item->content = $short_link ? $req->item_link : $req->content;
            $item->save();

            return response()->json(['success' => 'Link item successfully added']);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Something was wrong']);
        }
    }
    //--------------------------------------------------------


    //--------------------------------------------------------
    // Updating an element of bio-link
    public function EditLinkItem(Request $req, $itemId)
    {
        $item = LinkItem::find($itemId);

        if ($req->item_type == 'Link' || $req->item_type == 'Embed Link') {
            $rules = ['item_link' => 'required|url'];
            $messages = [
                'item_link.url' => 'Please provide a valid url',
                'item_link.required' => 'Item link is require',
            ];
            $this->validate($req, $rules, $messages);
        }

        if ($req->item_type == 'Link') {

            LinkItem::where('id', $itemId)->update([
                'item_title' => $req->item_title,
                'content' => $req->item_link,
            ]);

            Link::where('url_name', $item->item_link)->update([
                'link_name' => $req->item_title,
                'external_url' => $req->item_link,
            ]);

            return response()->json(['success' => 'Link item successfully updated']);
        }

        try {
            LinkItem::where('id', $itemId)->update([
                'item_type' => $req->item_type,
                'item_sub_type' => $req->item_sub_type,
                'item_title' => $req->item_title,
                'item_link' => $req->item_link,
                'content' => $req->content,
            ]);

            return response()->json(['success' => 'Link item successfully updated']);
        } catch (\Throwable $th) {
            return $th;
            return response()->json(['error' => 'Something was wrong']);
        }
    }
    //--------------------------------------------------------

    
    //--------------------------------------------------------
    // Delete an element of bio-link
    function DeleteLinkItem($itemId)
    {
        $item = LinkItem::find($itemId);

        if ($item->item_type == 'Image') {
            File::delete($item->content);
        }
        if ($item->item_type == 'Link') {
            Link::where('url_name', $item->item_link)->delete();
        }

        $item->delete();

        return back();
    }
    //--------------------------------------------------------


    //--------------------------------------------------------
    // Controlling the tap panel of bio-link editor page
    function BtnController(Request $req){
        $type = $req->input('type');

        if ($type == 'settings') {
            session()->forget(['settings', 'blocks']);
            session(['settings'=> true, 'blocks'=> false]);
        } else if ($type == 'blocks') {
            session()->forget(['blocks', 'blocks']);
            session(['settings'=> false, 'blocks'=> true]);
        }
        return;
    }
    //--------------------------------------------------------
}
