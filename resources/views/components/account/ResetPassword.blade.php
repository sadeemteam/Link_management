{{-- {{ url('/dashboard/account/update-password') }} --}}
<form class="row p-4" method="POST" action="{{url('/dashboard/account/update-password')}}">
    @csrf

    @if(session()->has('success'))
        <strong class="text-success" >{{session()->get('success')}}</strong>
    @endif
    @if(session()->has('error'))
        <strong class="text-error" >{{session()->get('error')}}</strong>
    @endif

    <div class="col-lg-6 mb-3">
        <label class="form-label">{{__('Current Password')}}</label>
        <input 
            name="current_password"
            type="password" 
            class="form-control @error('current_password') is-invalid @enderror" 
            placeholder="Type Current Password"
            required
        >
        @error('current_password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col-lg-6"></div>
    
    <div class="col-lg-6 mb-3">
        <label class="form-label">{{__('New Password')}}</label>
        <input 
            type="password" 
            name="password"
            placeholder="Type New Password"
            class="form-control @error('password') is-invalid @enderror" 
            required
        >
        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="col-lg-6 mb-3">
        <label class="form-label">{{__('Confirm New Password')}}</label>
        <input 
            type="password" 
            class="form-control" 
            name="password_confirmation" 
            placeholder="Confirm New Password"
            required
        >
    </div>

    <div>
        <button class="btn btn-primary text-white" type="submit">
            {{__('Save Changes')}}
        </button>
    </div>
</form>
