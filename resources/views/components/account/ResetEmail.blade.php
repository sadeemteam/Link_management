<form class="row p-4" method="POST" action="{{url('/dashboard/account/update-email')}}">
    @csrf

    @if(session()->has('success'))
        <strong class="text-success" >{{session()->get('success')}}</strong>
    @endif

    <div class="col-lg-6 mb-3">
        <label class="form-label">{{__('Current Email')}}</label>
        <input 
            type="email" 
            name="current_email"
            class="form-control" 
            placeholder="example@gmail.com"
            value="{{$user->email}}"
            required
        >
        @if(session()->has('error'))
            <p class="text-danger" style="font-weight: 500" >
                {{session()->get('error')}}
            </p>
        @endif
    </div>
    
    <div class="col-lg-6 mb-3">
        <label class="form-label">{{__('New Email')}}</label>
        <input 
            type="email" 
            name="email"
            class="form-control @error('email') is-invalid @enderror" 
            placeholder="example@gmail.com"
            required
        >
        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div>
        <button class="btn btn-primary text-white" type="submit">
            {{__('Save Changes')}}
        </button>
    </div>
</form>
