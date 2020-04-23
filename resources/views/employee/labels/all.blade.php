@extends('employee.layouts.app')

@section('page_title', __('employee/labels.page_title__all'))
@section('page_subtitle', "")

@section('content')
    
    @foreach($labels as $label_key => $label_value)
        <div class="card shadow-light mt-3">
            <div class="card--content">
                <div class="card--content--row width-padding">
                    <div class="text-xl text-bold pt-2">{{ $label_value['name'] }}</div>
                    <div class="text-lg">
                        {{ __('business/notifications.column_table__id') }}:
                        {{ $label_value['id'] }}
                    </div>
                    <a href="{{ route('employee.notifications.all', ['label_id' => $label_value['id']]) }}">
                        <button type="submit" class="d-inline-block bg-purple color-white p-1 text-lg mb-2 mt-1 cursor-pointer">{{ __('employee/labels.open_notifications_with_label_id') }}</button>
                    </a>
                </div>
            </div>
        </div>
    @endforeach

    @if(count($labels) < 1)
        <div class="text-lg text-bold mt-2">{{ __('business/tables.table__no_available_data') }}</div>
    @else 
        <div class="paginator">
            <div class="text-md text-bold mb-3">
                <span>{{ __('business/tables.table__found') }} {{ count($labels) }} {{ __('business/tables.table__records') }}.</span>
            </div>
        </div>
    @endif

@endsection