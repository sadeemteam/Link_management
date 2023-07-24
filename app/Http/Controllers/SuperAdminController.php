<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Theme;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

class SuperAdminController extends Controller
{
    // Getting user list
    public function index()
    {
        $roles = Role::all();

        $user = null;
        $all = User::all();
        foreach ($all as $item) {
            $role = $item->hasRole('SUPER-ADMIN');
            if ($role) {
                $user = $item;
                break;
            }
        }

        if ($user) {
            $users = User::where('id', '!=', $user->id)->paginate(10);

            return view('pages.admin.users', ["users"=>$users, "roles"=>$roles]);
        } else {
            return back()->with('error', 'Internal Server Error! Try again later');
        };
        
    }


    // Managing theme 
    public function ManageThemes()
    {
        $themes = Theme::all();

        return view('pages.admin.themes', compact("themes"));
    }

    public function TypeThemes(Request $request, $id)
    {
        try {
            Theme::where('id', $id)->update([
                'type' => $request->type
            ]);

            return back()->with('success', 'Theme type have changed');

        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Internal Server Error! Try again later');
        }
    }


    // Getting testimonials
    public function Testimonials()
    {
        $testimonials = Testimonial::all();
        return view('pages.admin.testimonials', compact('testimonials'));
    }


    // Add new testimonial
    public function AddTestimonial(Request $req)
    {
        $rules = [
            'testimonial' => 'max:180',
        ];
        $messages = [
            'testimonial.max' => 'Testimonial length must be 1 to 200 characters',
        ];
        $this->validate($req, $rules, $messages);

        $location = public_path('/upload/');
        $image = Image::make($req->thumbnail);
        $image->save($location.time().$req->thumbnail->getClientOriginalName());
        $imgUrl = 'upload/'.$image->filename.'.'.$image->extension;

        $res = new Testimonial();
        $res->name = $req->name;
        $res->title = $req->title;
        $res->thumbnail = $imgUrl;
        $res->testimonial = $req->testimonial;
        $res->save();

        return back();
    }

    // Delete a testimonial
    public function DeleteTestimonial($testimonialId)
    {
        $testimonial = Testimonial::find($testimonialId);
        File::delete($testimonial->thumbnail);
        $testimonial->delete();

        return back();
    }

    // Updating user role
    public function UpdateUser(Request $req, $id)
    {
        try {
            $user = User::where('id', $id)->first();
            $user->status = $req->status;
            $user->save();

            return back()->with(['success'=>'User Status Updated Successfully']);
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with(['error'=>$th->getMessage()]);
        }
    }
}

