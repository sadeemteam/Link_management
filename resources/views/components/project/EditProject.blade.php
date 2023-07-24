<div class="modal fade" id="updateProject" tabindex="-1" aria-labelledby="updateProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="updateProjectModalLabel">{{__('Update Project')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="/dashboard/update-project/{{$project->id}}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3 text-start">
                        <label class="form-label">{{__('Project Name')}}</label>
                        <input 
                            type="text" 
                            name="projectName"
                            class="form-control" 
                            placeholder="Type Content"
                            value="{{$project->project_name}}"
                            required
                        >
                    </div>

                    <button type="submit" class="mt-3 form-control btn btn-primary">
                        {{__('Update')}}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>