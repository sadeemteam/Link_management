<div class="modal fade" id="limitWarning" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <h5>{{__('Limit is full of your current plan')}}</h5>
                    <p>{{__('Please update your current plan to create more')}}</p>
                </div>
                <a 
                    class="form-control type-button btn btn-primary text-white" 
                    href="/dashboard/plan/select"
                >
                    {{__('Update Plan')}}
                </a>
            </div>
        </div>
    </div>
</div>