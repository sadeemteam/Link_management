<div class="card p-4">
    <form 
        method="POST" 
        action="{{route('settings.paystack')}}"
    >
        @csrf
        @method('PUT')

        <div class="d-flex align-items-center justify-content-between pb-4">
            <h5>{{__('Paystack Setup')}}</h5>

            <div class="form-check form-switch">
                <label class="form-check-label pe-5">Allow Paystack Payment</label>
                <input 
                    role="switch" 
                    type="checkbox" 
                    name="allow_paystack"
                    class="form-check-input" 
                    @if($paystack->active) checked @endif 
                >
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-12 col-md-6 mb-3">
                <label class="form-label">{{__('Paystack Key')}}</label>
                <input 
                    required 
                    type="password" 
                    name="paystack_key"
                    value="{{$paystack->key}}"
                    placeholder="Env value or api key"
                    class="form-control px-2" 
                >
            </div>
    
            <div class="col-12 col-md-6 mb-3">
                <label class="form-label">{{__('Paystack Secret')}}</label>
                <input 
                    required 
                    type="password" 
                    name="paystack_secret"
                    value="{{$paystack->secret}}"
                    placeholder="Env value or api key"
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