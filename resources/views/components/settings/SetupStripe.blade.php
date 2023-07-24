<div class="card p-4">
    <form 
        method="POST" 
        action="{{route('settings.stripe')}}"
    >
        @csrf
        @method('PUT')

        <div class="d-flex align-items-center justify-content-between pb-4">
            <h5>{{__('Stripe Setup')}}</h5>

            <div class="form-check form-switch">
                <label class="form-check-label pe-5">Allow Stripe Payment</label>
                <input 
                    role="switch" 
                    type="checkbox" 
                    name="allow_stripe"
                    class="form-check-input" 
                    @if($stripe->active) checked @endif 
                >
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-12 col-md-6 mb-3">
                <label class="form-label">{{__('Stripe Key')}}</label>
                <input 
                    required 
                    type="password" 
                    name="stripe_key"
                    value="{{$stripe->key}}"
                    placeholder="Stripe key paste here"
                    class="form-control px-2" 
                >
            </div>
    
            <div class="col-12 col-md-6 mb-3">
                <label class="form-label">{{__('Stripe Secret')}}</label>
                <input 
                    required 
                    type="password" 
                    value="{{$stripe->secret}}"
                    name="stripe_secret"
                    placeholder="Stripe secret paste here"
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