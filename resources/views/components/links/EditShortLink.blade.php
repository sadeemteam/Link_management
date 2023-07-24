<?php
    $iconClass = 'input-group-text bg-white pe-0 border';
?>

<div class="modal fade" id="editShortLink{{$link->id}}">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title">{{__('Create New Link')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <form action="/dashboard/update-link/{{$link->id}}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <input hidden name="link_type" value="shortlink">

                    <div class="mb-3 text-start">
                        <label class="form-label">{{__('Link Name')}}</label>

                        <input 
                            required 
                            name="link_name"
                            placeholder="Link Name"
                            value="{{$link->link_name}}"
                            class="form-control px-2"
                        >
                    </div>

                    <div class="mb-3 text-start">
                        <label class="form-label">{{__('External Url')}}</label>
                        <div class="input-group mb-4">
                            <input 
                                required 
                                name="external_url"
                                placeholder="https://example.com/..." 
                                value="{{$link->external_url}}"
                                class="form-control"
                            >
                        </div>
                    </div>

                    <button type="submit" class="mt-3 form-control btn btn-primary text-white">
                        {{__('Create')}}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>