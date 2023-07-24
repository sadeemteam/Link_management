<div class="modal fade" id="addTestimonial">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title">{{__('Add new testimonial')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form method="POST" action="/dashboard/testimonial/add" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3 text-center">
                        <img 
                            alt=""
                            width="200px" 
                            height="200px"
                            class="rounded-circle"
                            id="previewThumbnail" 
                            src="{{asset('assets/user-profile.png')}}"
                        >

                        <input 
                            required
                            type="file" 
                            name="thumbnail" 
                            id="thumbnail" 
                            class="form-control mt-3 @error('thumbnail') is-invalid @enderror"
                        >

                        @error('thumbnail')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">{{__('Name')}}</label>
                        <input 
                            required
                            name="name"
                            class="form-control" 
                            placeholder="Client name"
                        >

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{__('Title')}}</label>
                        <input 
                            required
                            name="title"
                            class="form-control" 
                            placeholder="Client title"
                        >

                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3 text-start">
                        <label class="form-label">{{__('Testimonial')}}</label>
                        <textarea 
                            rows="4" 
                            required 
                            name="testimonial" 
                            placeholder="Testimonial lenthe will be 1 to 180 characters" 
                            class="form-control px-2 @error('testimonial') is-invalid @enderror"
                        ></textarea>

                        @error('testimonial')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <button type="submit" class="mt-3 text-white form-control btn btn-primary">
                        {{__('Add')}}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById("thumbnail")?.addEventListener("change", function (e) {
        const reader = new FileReader();
        reader.readAsDataURL(e.target.files[0]);
        reader.addEventListener("load", () => {
            document.getElementById("previewThumbnail").src = reader.result;
        });
    });
</script>