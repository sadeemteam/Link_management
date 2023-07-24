<?php
    $iconClass = 'input-group-text bg-white pe-0 border';
    $inputClass = 'form-control px-2 border-start-0 rounded-end';
?>

<div class="modal fade" id="createLink">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title">{{__('Create New Link')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <form action="/dashboard/create-link" method="POST">
                    @csrf
                    <input hidden name="link_type" value="biolink">

                    <div class="mb-3">
                        <label class="form-label">{{__('Link Name')}}</label>
 
                        <input 
                            name="link_name"
                            placeholder="Link Name" 
                            class="form-control px-2"
                            type="text"
                        >

                        @error('link_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">{{__('Url Name')}}</label>

                        <div class="input-group">
                            <span class="input-group-text bg-white pe-0">/</span>
                            <input 
                                id="urlName"
                                name="url_name"
                                type="text"
                                placeholder="urlname" 
                                class="ps-0 {{$inputClass}}"
                            >

                            <script>
                                document.getElementById("urlName")
                                .addEventListener("change", function (item) {
                                    let result = item.target.value.replace(/\s+/g, '').toLowerCase();
                                    item.target.value = result;
                                });
                            </script>
                        </div>

                        @error('url_name')
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