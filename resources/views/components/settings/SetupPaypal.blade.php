<div class="card p-4">
    <form 
        method="POST" 
        action="{{route('settings.paypal')}}"
    >
        @csrf
        @method('PUT')

        <div class="d-flex align-items-center justify-content-between pb-4">
            <h5>{{__('Paypal Setup')}}</h5>

            <div class="form-check form-switch">
                <label class="form-check-label pe-5">Allow Paypal Payment</label>
                <input 
                    role="switch" 
                    type="checkbox" 
                    name="allow_paypal"
                    class="form-check-input" 
                    @if($paypal->active) checked @endif 
                >
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-12 col-md-6 mb-3">
                <label class="form-label">{{__('Paypal Client Id')}}</label>
                <input 
                    required 
                    type="password" 
                    name="paypal_client_id"
                    value="{{$paypal->key}}"
                    placeholder="Enter your paypal cliend id"
                    class="form-control px-2" 
                >
            </div>
    
            <div class="col-12 col-md-6 mb-3">
                <label class="form-label">{{__('Paypal Client Secret')}}</label>
                <input 
                    required 
                    type="password" 
                    name="paypal_client_secret"
                    value="{{$paypal->secret}}"
                    placeholder="Enter your paypal client secret"
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