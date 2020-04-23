@extends('employee.layouts.app')

@section('page_title', __('employee/notifications.page_title__all'))
@section('page_subtitle', "")

@section('content')
    
    <div class="filters-badges">
        <div class="text-lg text-bold">{{ __('employee/notifications.active_search_filters') }}</div>
        @if (count($notifications_filters) < 1)
            {{ __('employee/notifications.no_filters_applied') }}
        @endif
        @foreach ($notifications_filters as $notifications_filters_key => $notifications_filters_value)
            <div class="badge-purple">{{ $notifications_filters_value['label'] }}</div>
            <div class="badge-purple-outline badge-margin-left-minus-px">{{ $notifications_filters_value['value'] }}</div>
        @endforeach
    </div>

    @foreach($notifications as $notification_key => $notification_value)
        <div class="card shadow-light mt-3">
            <div class="card--content">
                <div class="card--content--row width-padding">
                    <div class="text-lg text-bold pt-2">{{ $notification_value['title'] }}</div>
                    <div class="text-lg text-bold">{{ $notification_value['body'] }}</div>
                    <div class="text-md">
                        {{ __('business/notifications.column_table__id') }}:
                        {{ $notification_value['id'] }}
                    </div>
                    <div class="text-md">
                        {{ __('business/notifications.column_table__created_at') }}:
                        <span class="text-bold">{{ $notification_value['created_at'] ? $notification_value['created_at']->format('H:i d-m-Y') : "-" }}</span>
                    </div>
                    <div class="text-md">
                        {{ __('business/notifications.column_table__updated_at') }}:
                        <span class="text-bold">{{ $notification_value['updated_at'] ? $notification_value['updated_at']->format('H:i d-m-Y') : "-" }}</span>
                    </div>
                    @if ($notification_value['state'] == '0')
                        <div class="badge-warning">{{ __('business/notifications.search_form__state__pending') }}</div>
                    @elseif ($notification_value['state'] == '1')
                        <div class="badge-success">{{ __('business/notifications.search_form__state__done') }}</div>
                    @endif
                </div>
                <div class="card--content--row width-full" style="{{ ($notification_value["state"] == 1) ? "display:none;" : "" }}">
                    <form action="{{ route('employee.notifications.complete_state_action') }}" class="login-page--form-container--login-form" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="notification_id" value="{{ $notification_value['id'] }}"/>
                        <button type="submit" class="card--content---button bg-purple color-white">{{ __('employee/notifications.change_state_to_completed') }}</button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    @if($notifications->total() < 1)
        <div class="text-lg text-bold mt-2">{{ __('business/tables.table__no_available_data') }}</div>
    @else 
        <div class="paginator">
            <div class="text-md text-bold mb-3">
                <span>{{ __('business/tables.table__found') }} {{ $notifications->total() }} {{ __('business/tables.table__records') }}.</span>
                <span>{{ $notifications->lastPage() }} {{ __('business/tables.table__available_pages') }}.</span>
            </div>
            <div class="paginator--label">Select page</div>
            <select onChange="_change_page(this)" class="paginator--select-page shadow-light">
                @for ($i=1; $i<=$notifications->lastPage(); $i++)
                    <option value="{{ $i }}" {{ $notifications->currentPage() == $i ? "selected" : "" }}>{{ $i }}</option>
                @endfor
            </select>
        </div>
    @endif

@endsection

@section('filters_content')
    <form id="_filters_content_form" action="{{ route('employee.notifications.all') }}" method="GET" enctype="multipart/form-data">
        <div class="filters--title">{{ __('business/notifications.search') }}</div>
        <div class="form-group">
            <label class="form-group--label">{{ __('business/notifications.column_table__id') }}</label>
            <input name="id" type="text" class="form-group--form-control shadow-light" placeholder="{{ __('business/notifications.column_table__id') }}" value="{{ app('request')->input('id') }}">
        </div>
        <div class="form-group">
            <label class="form-group--label">{{ __('business/notifications.column_table__label_id') }}</label>
            <input name="label_id" type="text" class="form-group--form-control shadow-light" placeholder="{{ __('business/notifications.column_table__label_id') }}" value="{{ app('request')->input('label_id') }}">
        </div>
        <div class="form-group">
            <label class="form-group--label">{{ __('business/notifications.column_table__title') }}</label>
            <input name="title" type="text" class="form-group--form-control shadow-light" placeholder="{{ __('business/notifications.column_table__title') }}" value="{{ app('request')->input('title') }}">
        </div>
        <div class="form-group">
            <label class="form-group--label">{{ __('business/notifications.column_table__body') }}</label>
            <input name="body" type="text" class="form-group--form-control shadow-light" placeholder="{{ __('business/notifications.column_table__body') }}" value="{{ app('request')->input('body') }}">
        </div>
        <div class="form-group">
            <label class="form-group--label">{{ __('business/notifications.column_table__state') }}</label>
            <select name="state" class="form-group--form-control shadow-light">
                <option value="0" {{ app('request')->input('state') == 0 || app('request')->input('state') == "" || app('request')->input('state') == null ? "selected" : "" }}>{{ __('business/notifications.search_form__state__pending') }}</option>
                <option value="1" {{ app('request')->input('state') == 1 ? "selected" : "" }}>{{ __('business/notifications.search_form__state__done') }}</option>
                <option value="9" {{ app('request')->input('state') == 9 ? "selected" : "" }}>{{ __('business/notifications.search_form__state__all') }}</option>
            </select>
        </div>
        <div class="form-group">
            <label class="form-group--label">{{ __('business/notifications.column_table__date_from') }}</label>
            <input name="date_from" type="date" class="form-group--form-control shadow-light" value="{{ app('request')->input('date_from') }}">
        </div>
        <div class="form-group">
            <label class="form-group--label">{{ __('business/notifications.column_table__date_to') }}</label>
            <input name="date_to" type="date" class="form-group--form-control shadow-light" value="{{ app('request')->input('date_to') }}">
        </div>
        <div class="form-group">
            <label class="form-group--label">{{ __('business/notifications.column_table__order_by') }}</label>
            <select name="order_by" class="form-group--form-control shadow-light">
                <option value="desc" {{ app('request')->input('order_by') == "desc" || app('request')->input('order_by') == "" || app('request')->input('order_by') == null ? "selected" : "" }}>{{ __('business/notifications.search_form__order_by_date__descending') }}</option>
                <option value="asc" {{ app('request')->input('order_by') == "asc" ? "selected" : "" }}>{{ __('business/notifications.search_form__order_by_date__ascending') }}</option>
            </select>
        </div>
        <input id="_filters_form_input__page" type="hidden" name="page" value=""/>
        <div class="form-group">
            <button type="submit" class="form-group--btn-primary shadow-longer bg-purple color-white">{{ __('business/notifications.search') }}</button>
            <a href="{{ route('employee.notifications.all') }}">
                <button type="button" class="form-group--btn-secondary shadow-longer">{{ __('business/notifications.clear') }}</button>
            </a>
        </div>
    </form>
@endsection

@section('footer_additional')
    @parent
    <script>
        function _change_page(e) {
            document.getElementById("_filters_form_input__page").value = e.value;
            document.getElementById("_filters_content_form").submit();
        }
    </script>
@endsection