<div class="card p-4">
    <form 
        method="POST" 
        action="{{route('settings.razorpay')}}"
    >
        @csrf
        @method('PUT')

        <div class="d-flex align-items-center justify-content-between pb-4">
            <h5>{{__('Razorpay Setup')}}</h5>

            <div class="form-check form-switch">
                <label class="form-check-label pe-5">Allow Razorpay Payment</label>
                <input 
                    role="switch" 
                    type="checkbox" 
                    name="allow_razorpay"
                    class="form-check-input" 
                    @if($razorpay->active) checked @endif 
                >
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-12 col-md-6 mb-3">
                <label class="form-label">{{__('Razorpay Key')}}</label>
                <input 
                    required 
                    type="password" 
                    name="razorpay_key"
                    value="{{$razorpay->key}}"
                    placeholder="Razorpay key paste here"
                    class="form-control px-2" 
                >
            </div>
    
            <div class="col-12 col-md-6 mb-3">
                <label class="form-label">{{__('Razorpay Secret')}}</label>
                <input 
                    required 
                    type="password" 
                    value="{{$razorpay->secret}}"
                    name="razorpay_secret"
                    placeholder="Razorpay secret key paste here"
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