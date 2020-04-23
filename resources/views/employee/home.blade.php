@extends('employee.layouts.app')

@section('page_title', __('employee/home.page_title__all'))
@section('page_subtitle', "")

@section('content')
    <div class="text-xl text-bold">{{ __('employee/home.section__profile.label') }}</div>
    <div class="card shadow-longer mt-2">
        <div class="card--content pt-3 pb-3">
            <div class="card--content--row width-padding">
                <div class="text-lg text-bold">{{ $employee['firstname'] . ' ' . $employee['lastname'] }}</div>
                <div class="text-md">{{ __('employee/home.section__profile.employee_id') }} {{ $employee['id'] }}</div>
                <div class="text-md">{{ __('employee/home.section__profile.business_id') }} {{ $employee['business_id'] }}</div>
            </div>
        </div>
    </div>
    <div class="text-xl text-bold mt-5">{{ __('employee/home.section__push.label') }}</div>
    @if ($employee->push_notification_token)
        <div class="card shadow-longer mt-2">
            <div class="card--content pt-3 pb-3">
                <div class="card--content--row width-padding">
                    <div class="text-md">{{ __('business/settings.form__webpush.unsubscribe_label') }}</div>
                </div>
            </div>
            <div class="card--content--row width-full">
                <form action="{{ route('employee.settings.update_push_token_action') }}" method="POST" enctype="multipart/form-data" class="col-12 row" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="__web_push_device_id" name="push_token"/>
                    <input type="hidden" name="reason" value="unsubscribe"/>
                    <button type="submit" class="card--content---button bg-purple color-white">{{ __('business/settings.form__webpush.unsubscribe_button') }}</button>
                </form>
            </div>
        </div>
    @else
        <div class="card shadow-longer mt-2">
            <div class="card--content pt-3 pb-3">
                <div class="card--content--row width-padding">
                    <div class="text-md">{{ __('business/settings.form__webpush.subscribe_label') }}</div>
                </div>
            </div>
            <div class="card--content--row width-full">
                <form action="{{ route('employee.settings.update_push_token_action') }}" method="POST" enctype="multipart/form-data" class="col-12 row" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="__web_push_device_id" name="push_token"/>
                    <input type="hidden" name="reason" value="subscribe"/>
                    <button type="submit" class="card--content---button bg-purple color-white">{{ __('business/settings.form__webpush.subscribe_button') }}</button>
                </form>
            </div>
        </div>
    @endif
@endsection