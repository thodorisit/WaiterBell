@extends('customer.layouts.app')

@php
    $data = \Session::get('flash__customer_additional_session_data');
@endphp

@section('meta_title', 'WaiterBell' . ' - ' . ($data['label']['id'] ?? ""))
@section('page_title', 'WaiterBell' . ' - ' . ($data['label']['id'] ?? ""))

@section('info__label_seat', $data['translations']['customer.home.seat'] ?? "")
@section('info__label_name', $data['label']['name'] ?? "")
@section('info__business_name', $data['business']['name'] ?? "")
@section('info__business_logo_url', $data['business']['logo_url'] ?? "")

@section('page_title', 'WaiterBell')

@section('content')
    @include('customer.layouts.topbar')
    <div class="content-message shadow-longer">
        <svg viewBox="0 0 24 24" class="content-page--icon success" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd">
            <path d="M24 4.685l-16.327 17.315-7.673-9.054.761-.648 6.95 8.203 15.561-16.501.728.685z"/>
        </svg>
        <div class="business-message text-align-center">
            {{ $data['translations']['customer.home.success_message'] ?? "-" }}
        </div>
    </div>
@endsection