<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\PricingPlan;
use Illuminate\Http\Request;
use App\Models\QRCode;
use App\Models\Project;

class QRCodeController extends Controller
{   
    //---------------------------------------------------
    // Getting all the qr-code of user or admin
    public function GetQRCodes()
    {
        $user = auth()->user();
        $SA = $user->hasRole('SUPER-ADMIN');
        $plan = PricingPlan::where('id', $user->pricing_plan_id)->first();

        if ($SA) {
            $qrcodes = QRCode::orderBy('created_at', 'desc')->paginate(10);
            return view('pages.admin.qrcodes', compact('qrcodes'));
            
        } else {
            $qrcodes = QRCode::where('user_id', '=', $user->id)->orderBy('created_at', 'desc')->paginate(10);

            if ($plan->qrcodes == 'Unlimited') {
                $limit_over = FALSE;
                return view('pages.qrcodes', compact('qrcodes', 'limit_over'));
            }

            if ($qrcodes->count() >= intval($plan->qrcodes)) {
                $limit_over = TRUE;
                return view('pages.qrcodes', compact('qrcodes', 'limit_over'));
            } else {
                $limit_over = FALSE;
                return view('pages.qrcodes', compact('qrcodes', 'limit_over'));
            }
        }
    }
    //---------------------------------------------------


    //---------------------------------------------------
    // Getting all the qr-code of user or admin
    public function GetProjectQRCodes($projectId)
    {
        $user = auth()->user();
        $project = Project::find($projectId);
        if (!$project) {
            abort(404);
        } else if($project->user_id == $user->id) {
            return view('pages.project-qrcodes', compact('project'));
        } else {
            return back();
        }
    }
    //---------------------------------------------------


    //---------------------------------------------------
    // Creating a new qr-code for bio-link
    function AddLinkQRCode(Request $req, $linkId) 
    {
        try {
            $user = auth()->user();
            $SA = $user->hasRole('SUPER-ADMIN');
            $link = Link::where('id', $linkId)->first();
            $plan = PricingPlan::where('id', $user->pricing_plan_id)->first();
            $nextPayment = $req->attributes->get('next_payment');

            if ($SA) {
                $result = new QRCode;
                $result->user_id = $user->id;
                $result->link_id = $link->id;
                $result->qr_type = "Link URL";
                $result->content = $req->content;
                $result->img_data = $req->img_data;
                $result->save();

                Link::where('id', $linkId)->update(['qrcode_id' => $result->id]);
                return $result;
            }

            if ($nextPayment) {
                return ['error' => "You can not create any qr code before update your current subscription."];
            } else {
                $qrcodes = QRCode::where('user_id', $user->id)->get();
                if ($plan->qrcodes != 'Unlimited' && $qrcodes->count() >= intval($plan->qrcodes)) {
                    return ['error' => 'QR Code create limit is full of your current plan'];
                    
                } else {
                    $result = new QRCode;
                    $result->user_id = $user->id;
                    $result->link_id = $link->id;
                    $result->qr_type = "Link URL";
                    $result->content = $req->content;
                    $result->img_data = $req->img_data;
                    $result->save();

                    Link::where('id', $linkId)->update(['qrcode_id' => $result->id]);
                    return $result;
                }
            }
        } catch (\Throwable $th) {
            return $th;
        }
    }
    //---------------------------------------------------


    //---------------------------------------------------
    // Accessing qr-code editor page
    function CreateQRCode(){
        $user = auth()->user();
        $projects = Project::where('user_id', '=', $user->id)->get();

        return view('pages.create_qrcode', ['projects'=>$projects ]);
    }
    //---------------------------------------------------


    //---------------------------------------------------
    // Creating a new qr-code for project
    function InsertQRCode(Request $req) 
    {
        $user = auth()->user();
        $projectId = $req->input('project_id');

        $result = new QRCode;
        $result->user_id = $user->id;
        $result->project_id = $projectId;
        $result->qr_type = $req->input('qr_type');
        $result->content = $req->input('content');
        $result->img_data = $req->input('img_data');
        $result->save();

        return $result;
    }
    //---------------------------------------------------


    //---------------------------------------------------
    // Delete qr code from bio-link or project
    function DeleteQRCode($qrCodeId) {
        $qrCode = QRCode::find($qrCodeId);
        
        if ($qrCode->link_id) {
            Link::where('id', $qrCode->link_id)->update(['qrcode_id' => NULL]);
        }
        $qrCode->delete();

        return back()->with('success', 'QR Code deleted successfully');;
    }
    //---------------------------------------------------
}
