<div class="card p-4">
    <form 
        method="POST" 
        action="{{route('settings.google')}}"
    >
        @csrf
        @method('PUT')

        <div class="d-flex align-items-center justify-content-between pb-4">
            <div>
                <h5>{{__('Goole Login Setup')}}</h5>
                <small>{{__('For user login or registraion')}}</small>
            </div>

            <div class="form-check form-switch">
                <label class="form-check-label pe-5">{{__('Allow Goole Login')}}</label>
                <input 
                    role="switch" 
                    type="checkbox" 
                    name="google_login_allow"
                    class="form-check-input" 
                    @if($google->active) checked @endif 
                >
            </div>
        </div>
        
        <div class="row">
            <div class="col-12 col-md-6 mb-4">
                <label class="form-label">{{__('Google Client Id')}}</label>
                <input 
                    required 
                    type="password" 
                    name="google_client_id"
                    value="{{$google->client_id}}"
                    placeholder="Enter your google client id"
                    class="form-control px-2" 
                >
            </div>
    
            <div class="col-12 col-md-6 mb-4">
                <label class="form-label">{{__('Google Client Secret')}}</label>
                <input 
                    required 
                    type="password" 
                    name="google_client_secret"
                    value="{{$google->client_secret}}"
                    placeholder="Enter your google client secret"
                    class="form-control px-2" 
                >
            </div>
    
            <div class="col-12 col-md-6 mb-3">
                <label class="form-label">{{__('Google Redirect Url')}}</label>
                <input 
                    required 
                    type="text" 
                    value="{{$google->redirect_url}}"
                    name="google_redirect"
                    placeholder="Enter your google redirect url"
                    class="form-control px-2" 
                >
            </div>
        </div>
        
        <button 
            type="submit" 
            class="mt-3 px-3 btn btn-primary"
        >
            {{__('Save Changes')}}
        </button>
    </form>
</div>