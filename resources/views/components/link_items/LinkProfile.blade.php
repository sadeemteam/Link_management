<div class="card p-4 mb-4">
    
    <form method="POST" action="/dashboard/update-link-profile/{{$link->id}}" enctype="multipart/form-data">
        @csrf
        @method("PUT")

        <div class="linkProfile">
            <h4 class="title">{{__('Profile')}}</h4>
            <div class="imageContainer">
                <div class="imageBox">
                    <img 
                        alt=""
                        id="linkProfileImg" 
                        src="{{$link->thumbnail ? asset($link->thumbnail) : asset('assets/user-profile.png')}}" 
                    >
                    <label class="imageUploader" for="linkProfileInput">
                        <i class="fa-solid fa-camera"></i>
                    </label>
                    <input 
                        hidden 
                        type="file" 
                        name="thumbnail"
                        id="linkProfileInput"
                    >
                    @error('thumbnail')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
    
            <div class="inputBox">
                <div class="mb-3">
                    <label class="form-label">{{__('Link Name')}}</label>
                    <input 
                        required 
                        type="text" 
                        placeholder="Name" 
                        name="link_name" 
                        value="{{$link->link_name}}" 
                        class="form-control" 
                    >
                </div>
    
                <div>
                    <label class="form-label">{{__('Short Bio')}}</label>
                    <textarea 
                        rows="3" 
                        required 
                        name="link_bio" 
                        placeholder="Write something about you." 
                        class="form-control @error('link_bio') is-invalid @enderror"
                    >{{$link->short_bio}}</textarea>

                    @error('link_bio')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>

        <button class="w-100 btn btn-primary text-white mt-4" >
            {{__('Save')}}
        </button>
    </form>
</div>