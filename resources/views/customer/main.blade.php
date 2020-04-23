@extends('customer.layouts.app')

@section('meta_title', 'WaiterBell' . ' - ' . app('request')->input('label_id'))
@section('page_title', 'WaiterBell' . ' - ' . app('request')->input('label_id'))

@section('info__label_seat', $translations['customer.home.seat'])
@section('info__label_name', $label['name'] )
@section('info__business_name', $business['name'] )
@section('info__business_logo_url', $business['logo_url'] )

@section('content')
    @include('customer.layouts.menu')
    @include('customer.layouts.topbar')
    <div class="content-page">
        
        <div class="business-message">
            {{ $translations['customer.home.choose_reason'] }}
        </div>

        @foreach($request_types as $key => $value)
            <div class="request-item shadow-longer">
                <form action="{{ route('customer.request_action') }}" method="POST" enctype="multipart/form-data" class="request-item--form">
                    @csrf
                    <input type="hidden" value="{{ app('request')->input('label_id') }}" name="label_id"/>
                    <input type="hidden" value="{{ $value['id'] }}" name="request_id"/>
                    <button class="request-item--form--submit" type="submit" name="submit">{{ $value['name'] }}</button>
                </form>
            </div>
        @endforeach

    </div>
@endsection