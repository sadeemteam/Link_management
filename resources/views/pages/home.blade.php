@extends('layouts.app')

<?php
$user = auth()->user();
$SA = false;
if ($user) {
    $roleSA = $user->hasRole('SUPER-ADMIN');
    $editHome = request()->edithome;
    $SA = $roleSA && $editHome ? true : false;
}
?>

@section('content')
    @if (session('error'))
        @include('components.Toast', ['toastType' => 'error', 'message' => session('error')])
    @endif

    @include('components.home.Header2')
    <hr class="border-top" />
    @include('components.home.Features')

    @include('components.home.CreateLink')

    @include('components.home.Blocks')

    {{-- <hr class="border-top" /> --}}
    @include('components.home.CreateQR')

    {{-- <hr class="border-top" /> --}}
    @include('components.home.Pricing')

    {{-- <hr class="border-top" /> --}}
    @include('components.home.Testimonials')

    @include('components.home.Footer')
@endsection
