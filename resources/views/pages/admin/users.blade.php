@extends('layouts.dashboard.dashboard')

@section('content')
<div class="container">
    @if (session('success'))
        @include('components.Toast', ['toastType' => 'success', 'message' => session('success')])
    @endif

    <div class="d-flex justify-content-between py-4">
        <h5 style="font-size: 22px">{{__('Users')}}</h5>
    </div>
    @if(count($users) > 0)
        <div class="card overflow-auto">           
            <table class="table table-borderless styled-table">
                <thead>
                    <tr>
                        <th scope="col">{{__('Photo')}}</th>
                        <th scope="col" class="text-center">{{__('Name')}}</th>
                        <th scope="col" class="text-center">{{__('Email')}}</th>
                        <th scope="col" class="text-center">{{__('Status')}}</th>
                        <th scope="col" class="text-center">{{__('Pricing Plan')}}</th>
                        <th scope="col" class="text-end">{{__('Action')}}</th>
                    </tr>
                </thead>
                
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <th scope="row" class="align-middle">
                                <img 
                                    alt=""
                                    width="40px" 
                                    height="40px" 
                                    class="rounded-circle"
                                    src="{{$user->image ? asset($user->image) : asset('assets/user-profile.png')}}" 
                                >
                            </th>
                            <td class="text-center align-middle visited"> 
                                <p>{{$user->name}}</p>
                            </td>
                            <td class="text-center align-middle visited"> 
                                <span>
                                    {{$user->email}}
                                </span>
                            </td>
                            <td class="text-center align-middle visited"> 
                                <span>
                                    {{$user->status}}
                                </span>
                            </td>
                            <td class="text-center align-middle">
                                <span>
                                    {{$user->pricing_plan_id ? $user->pricing_plan->name : '...'}}
                                </span>
                            </td>

                            <td class="align-middle d-flex justify-content-end">
                                <button 
                                    class="btn link-control" 
                                    data-bs-toggle="modal"
                                    data-bs-target="#updateRole{{$user->id}}"
                                >
                                    <i class="fa-duotone fa-pen-circle"></i>
                                </button>
                                @include('components.admin.UpdateRole')
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3 d-flex justify-content-center">
                {{ $users->links() }}
            </div>
        </div>
    @else
        <div class="card py-4 px-3 shadow-sm border-0 text-center">
            <h5>{{__('No have any project')}}</h5>
        </div>
    @endif
</div>
@endsection
