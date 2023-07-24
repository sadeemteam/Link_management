<div 
   tabindex="-1" 
   aria-hidden="true"
   class="modal fade" 
   id="deleteItem{{$id}}" 
   aria-labelledby="deleteItemModalLabel" 
>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center py-5 px-3 px-md-5">
            <h3>{{__('Are you sure?')}}</h3>
            <p class="text-secondary py-3">
               {{__('Do you really want to delete these records? This process cannot be undone.')}}
            </p>

            <div class="d-flex justify-content-center">
               <button 
                  type="button" 
                  class="btn btn-secondary me-3" 
                  data-bs-dismiss="modal" 
                  aria-label="Close"
               >
                  {{__('Cancel')}}
               </button>

               <form method="POST" action="{{$action}}">
                  @csrf
                  @method('DELETE')

                  <button type="submit" class="btn btn-danger">
                     {{__('Delete')}}
                  </button>
               </form>
            </div>
        </div>
    </div>
</div>