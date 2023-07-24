<?php
    $iconClass = 'input-group-text bg-white pe-0 border';
    $inputClass = 'form-control px-2 border-start-0 rounded-end';
?>
<div class="modal fade" id="editLink{{$link->id}}" tabindex="-1" aria-labelledby="editLinkModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="editLinkModalLabel">{{__('Update Project')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="/dashboard/update-link/{{$link->id}}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3 text-start">
                        <label class="form-label">{{__('User Name')}}</label>

                        <input 
                            required 
                            name="link_name"
                            placeholder="User Name"
                            value="{{$link->link_name}}"
                            class="form-control px-2"
                        >
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{__('Url Name')}}</label>

                        <div class="input-group">
                            <span class="input-group-text bg-white pe-0">/</span>
                            <input 
                                id="urlNameEdit"
                                name="url_name"
                                placeholder="urlname" 
                                value="{{$link->url_name}}"
                                class="ps-0 {{$inputClass}}"
                            >

                            <script>
                                document.getElementById("urlNameEdit")
                                .addEventListener("change", function (item) {
                                    let result = item.target.value.replace(/\s+/g, '').toLowerCase();
                                    item.target.value = result;
                                });
                            </script>
                        </div>
                    </div>

                    <button type="submit" class="mt-3 text-white form-control btn btn-primary">
                        {{__('Update')}}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>