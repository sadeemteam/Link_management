<div class="modal fade" id="updateRole{{$user->id}}">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title">{{__('Update User Status')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('user-update', $user->id)}}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3" id="currency">
                        <label class="form-label">{{__('Status')}}</label>
                        <select 
                            required
                            name="status" 
                            class="form-control px-2"
                        >
                            <option disabled selected class="d-none">
                                {{__('Update Role')}}
                            </option>

                            <option value="active" selected>{{__('Active')}}</option>
                            <option value="deactive">{{__('Deactive')}}</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="mt-3 form-control btn btn-primary">
                        Update
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>