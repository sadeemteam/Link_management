@extends('layouts.dashboard.dashboard')

@section('content')
    <div class="container">
        @if (session('success'))
            @include('components.Toast', ['toastType' => 'success', 'message' => session('success')])
        @endif

        <div class="d-flex justify-content-between py-4">
            <h5 style="font-size: 22px">{{__('Links')}}</h5>
            <button 
                data-bs-toggle="modal" 
                class="btn btn-primary text-white px-4" 
                data-bs-target="#projectCreate"
            >
                <i class="fa-solid fa-circle-plus" style="font-size: 14px"></i>
                {{__('Create Project')}}
            </button>

            @include('components.project.CreateProject')
        </div>

        @if (count($projects) > 0)
            <div class="card overflow-auto">
                <table class="table table-borderless styled-table">
                    <thead>
                        <tr>
                            <th scope="col form-check">
                                <label class="form-check-label">
                                    {{__('Project Name')}}
                                </label>
                            </th>
                            <th scope="col" class="text-center">{{__('Project QRCode')}}</th>
                            <th scope="col" class="text-center">{{__('Publish Date')}}</th>
                            <th scope="col" class="text-end">{{__('Action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($projects as $project)
                            <tr>
                                <th scope="row" class="align-middle">
                                    <p class="m-0">{{ $project->project_name }}</p>
                                </th>
                                <td class="text-center align-middle">
                                    @if ($project->qrcode_id)
                                        <img width="40px" src="{{ $project->qrcode->img_data }}" alt="...">
                                    @else
                                        <span>{{__('Empty')}}</span>
                                    @endif
                                </td>
                                <td class="text-center align-middle">
                                    <span>{{ $project->created_at->format('d M, y') }}</span>
                                </td>

                                <td class="align-middle d-flex justify-content-end">
                                    <button 
                                        class="btn link-control" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#updateProject"
                                    >
                                        <i class="fa-duotone fa-pen-circle"></i>
                                    </button>

                                    <button 
                                        class="btn link-control" 
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteItem{{$project->id}}"
                                    >
                                        <i class="fa-duotone fa-circle-trash text-danger"></i>
                                    </button>

                                    @include('components.DeletePopup', [
                                        'id' => $project->id, 
                                        'action' => "/dashboard/delete-project/".$project->id
                                    ])

                                    @include('components.project.EditProject')
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-3 d-flex justify-content-center">
                    {{ $projects->links() }}
                </div>
            </div>
        @else
            <div class="card py-4 px-3 shadow-sm border-0 text-center">
                <h5>{{__('No have any project')}}</h5>
            </div>
        @endif
    </div>
@endsection
