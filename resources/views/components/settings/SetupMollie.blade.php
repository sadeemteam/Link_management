<div class="card p-4">
    <form 
        method="POST" 
        action="{{route('settings.mollie')}}"
    >
        @csrf
        @method('PUT')

        <div class="d-flex align-items-center justify-content-between pb-4">
            <h5>{{__('Mollie Setup')}}</h5>

            <div class="form-check form-switch">
                <label class="form-check-label pe-5">Allow Mollie Payment</label>
                <input 
                    role="switch" 
                    type="checkbox" 
                    name="allow_mollie"
                    class="form-check-input" 
                    @if($mollie->active) checked @endif 
                >
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-12 col-md-6 mb-3">
                <label class="form-label">{{__('Mollie Key')}}</label>
                <input 
                    required 
                    type="password" 
                    name="mollie_key"
                    value="{{$mollie->key}}"
                    placeholder="Enter your mollie key"
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