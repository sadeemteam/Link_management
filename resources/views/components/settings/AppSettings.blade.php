<form 
    method="POST" 
    class="appSetting card p-4" 
    action="{{route('settings.global')}}"
    enctype="multipart/form-data"
>
    @csrf
    @method('PUT')

    <div>
        <div class="previewProfile">
            <img 
                alt=""
                width="100%" 
                id="profileImg" 
                src="/{{$app->logo}}"
            >
            <label for="profile" class="form-label">{{__('Change Logo')}}</label>
            <input hidden id="profile" name="app_logo" type="file" >
        </div>
        <input hidden class="@error('app_logo') is-invalid @enderror">
        @error('app_logo')
            <p class="invalid-feedback text-center" role="alert">
                {{ $message }}
            </p>
        @enderror
    </div>

    <div class="inputBox">
        <div class="mb-3">
            <label class="form-label">{{__('App Title')}}</label>
            <input 
                required
                name="app_name"
                class="form-control" 
                value="{{$app->title}}"
            >
            @error('app_name')
                <small class="text-danger">{{$message}}</small>
            @enderror
        </div>
        
        <div class="mb-3">
            <label class="form-label">{{__('Copyright')}}</label>
            <input 
                required
                name="app_copyright"
                class="form-control" 
                value="{{$app->copyright}}"
            >
            @error('app_copyright')
                <small class="text-danger">{{$message}}</small>
            @enderror
        </div>

        <div class="mb-3 text-start">
            <label class="form-label">{{__('App Description')}}</label>
            <textarea 
                rows="3" 
                required 
                name="description"
                placeholder="Section Tiltle" 
                class="form-control px-2 @error('description') is-invalid @enderror"
            >{{$app->description}}</textarea>

            @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <button 
            type="submit" 
            class="mt-3 px-3 btn btn-primary"
        >
            {{__('Save Changes')}}
        </button>
    </div>
</form>
