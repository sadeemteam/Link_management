<?php

namespace App\Http\Controllers;

use App\Models\PricingPlan;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\QRCode;

class ProjectController extends Controller
{
    //-------------------------------------------------------
    // Getting the all project of user or admin
    public function Project() 
    {
        $user = auth()->user();
        $SA = $user->hasRole('SUPER-ADMIN');
        $plan = PricingPlan::where('id', $user->pricing_plan_id)->first();
        
        if ($SA) {
            $projects = Project::orderBy('created_at', 'desc')->paginate(10);
            return view('pages.admin.projects', compact('projects'));
            
        } else {
            $projects = Project::where('user_id', '=', $user->id)->orderBy('created_at', 'desc')->paginate(10);

            if ($plan->projects == 'Unlimited') {
                $limit_over = FALSE;
                return view('pages.projects', compact('projects', 'limit_over'));
            }

            if ($projects->count() >=  intval($plan->projects)) {
                $limit_over = TRUE;
                return view('pages.projects', compact('projects', 'limit_over'));
            } else {
                $limit_over = FALSE;
                return view('pages.projects', compact('projects', 'limit_over'));
            }
        }
    }
    //-------------------------------------------------------


    //-------------------------------------------------------
    // Create a new project
    public function CreateProject(Request $req) {
        $user = auth()->user();
        $projectName = $req->input('projectName');

        $result = new Project;
        $result->user_id = $user->id;
        $result->project_name = $projectName;
        $result->save();

        return back()->with('success', 'Project created successfully');;
    }
    //-------------------------------------------------------


    //-------------------------------------------------------
    // Create a new project
    public function UpdateProject(Request $req, $projectId) 
    {
        Project::where('id', $projectId)->update([
            'project_name' => $req->projectName,
        ]);
 
        return back()->with('success', 'Project updated successfully');;
    }
    //-------------------------------------------------------


    //-------------------------------------------------------
    // Delete project
    public function DeleteProject($projectId) 
    {
        $project = Project::find($projectId);
        if ($project->qrcode_id) {
            QRCode::find($project->qrcode_id)->delete();
        }
        $project->delete();

        return back()->with('success', 'Project deleted successfully');;
    }
    //-------------------------------------------------------
}
