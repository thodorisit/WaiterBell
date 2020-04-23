@extends('business.layouts.app')

@section('meta_title', __('business/employees.meta_title__show') )
@section('page_title', __('business/employees.page_title__show') )

@section('sidebar')
    @parent
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12 mb-4">
            <a href="{{ route('business.employees.edit', ['id' => app('request')->input('id')]) }}">
                <button class="btn-sm btn-secondary">{{ __('business/employees.edit_employee') }}</button>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4 pt-2">
                <div class="card-body">
                    <span class="d-block">{{ __('business/employees.column_table__id') }}: {{ $employee['id'] }}</span>
                    <h4 class="d-block">{{ $employee['firstname'] . ' ' . $employee['lastname'] }}</h4>
                    <div id="table_row_column__password_value_{{$employee['id']}}" class="d-none">{{ __('business/employees.column_table__password') . ': ' . $employee['password'] }}</div>
                    <button id="table_row_column__password_button_{{$employee['id']}}" onClick="tablePassword.show({{$employee['id']}});" class="btn-sm btn-danger">{{ __('business/employees.column_table__password__view_password') }}</button>
                    @if (!empty($employee['login_token']))
                        <form action="{{ route('business.employees.revoke_login_token') }}" method="POST" enctype="multipart/form-data" class="d-inline mt-1">
                            @csrf
                            <button class="btn-sm btn-outline-danger mt-1 mb-1">{{ __('business/employees.table__revoke_login_token') }}</button>
                            <input name="id" type="hidden" value="{{ app('request')->input('id') }}"/>
                        </form>
                        @if (!empty($employee['push_notification_token']))
                            <form action="{{ route('business.employees.revoke_push_token') }}" method="POST" enctype="multipart/form-data" class="d-inline mt-1 ml-1">
                                @csrf
                                <button class="btn-sm btn-outline-danger mt-1 mb-1">{{ __('business/employees.table__revoke_push_token') }}</button>
                                <input name="id" type="hidden" value="{{ app('request')->input('id') }}"/>
                            </form>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header">
            <div class="row">
                <div class="col-md-12">
                    {{ __('business/employees.search_through_labels_connected_to_this_employee') }}
                </div>
                <div class="col-md-12">
                    <a href="{{ route('business.connect_labels_employees.init', ['employee_id' => app('request')->input('id')]) }}">
                        <button class="btn-sm btn-primary mt-1 mb-1">{{ __('business/employees.table__button_connect_label_to_employee') }}</button>
                    </a>
                </div>
            </div>
        </div>
        <div class="card-header bg-white">
            <div class="row">
                <form action="{{ route('business.employees.show') }}" method="GET" enctype="multipart/form-data" class="col-md-12 row">
                    <div class="form-group col-md-6 col-sm-12">
                        <label>{{ __('business/labels.column_table__label__name') }}</label>
                        <input name="label_name" type="text" class="form-control" placeholder="" value="{{ app('request')->input('label_name') }}">
                        <small class="form-text text-muted"></small>
                    </div>
                    <input name="id" type="hidden" value="{{ app('request')->input('id') }}"/>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">{{ __('business/employees.search') }}</button>
                        <a href="{{ route('business.employees.show', ['id' => app('request')->input('id')]) }}">
                            <button type="button" class="btn btn-secondary">{{ __('business/employees.clear') }}</button>
                        </a>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>{{ __('business/labels.column_table__label__name') }}</th>
                            <th>{{ __('business/tables.table__actions') }}</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>{{ __('business/labels.column_table__label__name') }}</th>
                            <th>{{ __('business/tables.table__actions') }}</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @if(count($table) == '0')
                            <tr>
                                <td colspan="5">{{ __('business/tables.table__no_available_data') }}</td>
                            </tr>
                        @else
                            @foreach($table as $item)
                                <tr>
                                    <td>{{$item->name}}</td>
                                    <td>
                                        <a href="{{ route('business.labels.show', ['id' => $item->id]) }}">
                                            <button class="btn-sm btn-primary mt-1 mb-1">{{ __('business/employees.table__show_label') }}</button>
                                        </a>
                                        <form action="{{ route('business.labels.remove_employee_action') }}" method="POST" enctype="multipart/form-data" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn-sm btn-danger mt-1 mb-1">{{ __('business/labels.table__remove_employee') }}</button>
                                            <input name="label_id" type="hidden" value="{{ $item->id }}"/>
                                            <input name="employee_id" type="hidden" value="{{ $employee['id'] }}"/>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    {{ $table->links() }}
                </div>
                <div class="col-md-6 col-sm-12">
                    <span>{{ __('business/tables.table__found') }} {{ $table->total() }} {{ __('business/tables.table__records') }}.</span>
                    <span>{{ $table->lastPage() }} {{ __('business/tables.table__available_pages') }}.</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_additional')
    @parent
    <script>
        var tablePassword = {
            show : function(id) {
                document.getElementById('table_row_column__password_button_'+id).classList.add('d-none');
                document.getElementById('table_row_column__password_value_'+id).classList.remove('d-none');
                document.getElementById('table_row_column__password_value_'+id).classList.add('d-block');
            }
        };
    </script>
@endsection