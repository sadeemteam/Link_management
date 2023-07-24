<form class="settingForm" action="/dashboard/account/update-setting" enctype="multipart/form-data" method="POST">
    @csrf
    @method("PUT")
    
    <div>
        <div class="previewProfile">
            <img 
                alt=""
                width="100%" 
                id="profileImg" 
                src="{{$user->image ? asset($user->image) : asset('assets/user-profile.png')}}" 
            >
            <label for="profile" class="form-label">{{__('Upload Image')}}</label>
            <input id="profile" name="image" class="d-none" type="file">
        </div>
    </div>

    <div class="inputBox">
        <div class="mb-3">
            <label class="form-label">{{__('Name')}}</label>
            <input 
                name="name"
                type="text" 
                value="{{$user->name}}"
                class="form-control" 
                placeholder="example: Jamir Hossain"
                required
            >
        </div>
        
        <div class="mb-3">
            <label class="form-label">{{__('Phone')}}</label>
            <input 
                name="phone"
                type="number" 
                value="{{$user->phone ? $user->phone : ""}}"
                class="form-control" 
                placeholder="+88 23478238"
            >
        </div>

        <div>
            <button class="btn btn-primary text-white" type="submit">
                {{__('Save Changes')}}
            </button>
        </div>
    </div>
</form>
