@extends('layouts.dashboard.dashboard')
<?php $user = auth()->user();?>

@section('content')
<div class="container">
    <div class="d-flex justify-content-between py-4">
        <h5 style="font-size: 22px">{{__('Payments History')}}</h5>
    </div>

    @if(count($subscriptions) > 0)
        <div class="card overflow-auto">           
            <table class="table table-borderless styled-table">
                <thead>
                    <tr>
                        <th scope="col" class="">{{__('Payment Method')}}</th>
                        <th scope="col" class="text-center">{{__('Billing Type')}}</th>
                        <th scope="col" class="text-center">{{__('Transaction Id')}}</th>
                        <th scope="col" class="text-center">{{__('Total Price')}}</th>
                        <th scope="col" class="text-end">{{__('Paid On')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subscriptions as $item)
                        <tr>
                            <td class="align-middle"> 
                                <span>
                                    {{ucfirst($item->method)}}
                                </span>
                            </td>
                            <td class="text-center align-middle"> 
                                <span>
                                    {{$item->billing}}
                                </span>
                            </td>
                            <td class="text-center align-middle">
                                <span>
                                    {{$item->transaction_id}}
                                </span>
                            </td>
                            <td class="text-center align-middle">
                                <span>
                                    {{$item->total_price}} {{$item->currency}}
                                </span>
                            </td>
                            <td class="text-end align-middle">
                                <span>{{$item->created_at->format('d M, y')}}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="card py-4 px-3 shadow-sm border-0 text-center">
            <h5>{{__('No have any project')}}</h5>
        </div>
    @endif
</div>
@endsection
