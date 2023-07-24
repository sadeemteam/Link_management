<div class="modal fade" id="projectCreate" tabindex="-1" aria-labelledby="projectCreateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="projectCreateModalLabel">{{__('Create Project')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="/dashboard/create-project">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">{{__('Project Name')}}</label>
                        <input 
                            type="text" 
                            name="projectName"
                            class="form-control" 
                            placeholder="Type Content"
                            required
                        >
                    </div>
                    <button type="submit" class="mt-3 form-control btn btn-primary">
                        {{__('Create')}}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>