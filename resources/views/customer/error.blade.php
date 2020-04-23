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
        <svg viewBox="0 0 24 24" class="content-page--icon error" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd">
            <path d="M12 11.293l10.293-10.293.707.707-10.293 10.293 10.293 10.293-.707.707-10.293-10.293-10.293 10.293-.707-.707 10.293-10.293-10.293-10.293.707-.707 10.293 10.293z"/>
        </svg>
        <div class="business-message text-align-center">
            {{ $data['translations']['customer.home.error_message'] ?? "-" }}
        </div>
    </div>
@endsection