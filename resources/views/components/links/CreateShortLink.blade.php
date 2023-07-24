<?php
    $iconClass = 'input-group-text bg-white pe-0 border';
?>

<div class="modal fade" id="createShortLink">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title">{{__('Create New Link')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <form action="/dashboard/create-link" method="POST">
                    @csrf
                    <input hidden name="link_type" value="shortlink">

                    <div class="mb-3 text-start">
                        <label class="form-label">{{__('Link Name')}}</label>

                        <input 
                            required 
                            name="link_name"
                            placeholder="Link Name"
                            value="{{old('link_name')}}"
                            class="form-control px-2"
                        >

                        @error('link_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3 text-start mb-4">
                        <label class="form-label">{{__('External Url')}}</label>
                        <div class="input-group">
                            <input 
                                required 
                                name="external_url"
                                placeholder="https://example.com/..." 
                                value="{{old('external_url')}}"
                                class="form-control"
                            >
                        </div>

                        @error('external_url')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <button type="submit" class="mt-3 form-control btn btn-primary text-white">
                        {{__('Create')}}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>