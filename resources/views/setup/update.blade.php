@extends('setup.main2')
@section('content')
<meta name="csrf_token" content="{{ csrf_token() }}" />


    <div class="row mt-3">
        <div class="loader d-none">Loading...</div>
    </div>

    <div class="row mt-3 p-5 d-block" id="content">

        <div class="col-12">

            <form  action="/version/update" method="post">
                @csrf

                <h3 class="mb-5">Do you update current version to new version?</h3>

                <button 
                    type="submit" 
                    class="btn btn-primary mb-2 btn-block" 
                >
                    Confirm <i class="fa fa-check"></i>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
