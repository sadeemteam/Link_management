@extends('setup.main2')
@section('content')

    <div class="row mt-3 p-5">
        <div class="col-12">
            <h4 class="mb-4">Login Admin</h4>

            @if (session('error'))
                <p>{{session('error')}}</p>
            @endif
            
            <form action="/admin/login" method="post">
                @csrf
                <div class="form-group">
                    <label for="email">Admin Email</label>
                    <span class="tip" title="Admin Email"><i class="fa fa-question-circle" aria-hidden="true"></i></span>

                    <input type="email" class="form-control" id="email" name="email" placeholder="Admin Email" autofocus>
                </div>

                <div class="form-group">
                    <label for="password">Admin Password</label> <span class="tip" title="Admin Password"><i class="fa fa-question-circle" aria-hidden="true"></i></span>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" autofocus>
                </div>

                <button 
                    id="next" 
                    type="submit" 
                    class="btn btn-outline-danger mt-3 float-md-right"
                >
                    Next Step <i class="fa fa-angle-right"></i>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
