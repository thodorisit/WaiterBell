@extends('business.layouts.app')

@section('meta_title', __('business/labels.meta_title__show') )
@section('page_title', __('business/labels.page_title__show') )

@section('sidebar')
    @parent
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12 mb-4">
            <a href="{{ route('business.labels.edit', ['id' => app('request')->input('id')]) }}">
                <button class="btn-sm btn-secondary">{{ __('business/labels.edit_label') }}</button>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4 pt-2">
                <div class="card-body">
                    <span class="d-block">{{ __('business/labels.column_table__label__id') }}: {{ $label['id'] }}</span>
                    <h2 class="d-block">{{ $label['name'] }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header">
            <div class="row">
                <div class="col-md-12">
                    {{ __('business/labels.search_through_employees_connected_to_this_label') }}
                </div>
                <div class="col-md-12">
                    <a href="{{ route('business.connect_labels_employees.init', ['label_id' => app('request')->input('id')]) }}">
                        <button class="btn-sm btn-primary mt-1 mb-1">{{ __('business/labels.table__button_connect_employees_to_label') }}</button>
                    </a>
                </div>
            </div>
        </div>
        <div class="card-header bg-white">
            <div class="row">
                <form action="{{ route('business.labels.show') }}" method="GET" enctype="multipart/form-data" class="col-md-12 row">
                    <div class="form-group col-md-6 col-sm-12">
                        <label>{{ __('business/labels.column_table__id') }}</label>
                        <input name="employee_id" type="text" class="form-control" placeholder="" value="{{ app('request')->input('employee_id') }}">
                        <small class="form-text text-muted"></small>
                    </div>
                    <div class="form-group col-md-6 col-sm-12">
                        <label>{{ __('business/labels.column_table__firstname') }}</label>
                        <input name="employee_firstname" type="text" class="form-control" placeholder="" value="{{ app('request')->input('employee_firstname') }}">
                        <small class="form-text text-muted"></small>
                    </div>
                    <div class="form-group col-md-6 col-sm-12">
                        <label>{{ __('business/labels.column_table__lastname') }}</label>
                        <input name="employee_lastname" type="text" class="form-control" placeholder="" value="{{ app('request')->input('employee_lastname') }}">
                        <small class="form-text text-muted"></small>
                    </div>
                    <input name="id" type="hidden" value="{{ app('request')->input('id') }}"/>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">{{ __('business/labels.search') }}</button>
                        <a href="{{ route('business.labels.show', ['id' => app('request')->input('id')]) }}">
                            <button type="button" class="btn btn-secondary">{{ __('business/labels.clear') }}</button>
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
                            <th>{{ __('business/labels.column_table__id') }}</th>
                            <th>{{ __('business/labels.column_table__firstname') }}</th>
                            <th>{{ __('business/labels.column_table__lastname') }}</th>
                            <th>{{ __('business/tables.table__actions') }}</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>{{ __('business/labels.column_table__id') }}</th>
                            <th>{{ __('business/labels.column_table__firstname') }}</th>
                            <th>{{ __('business/labels.column_table__lastname') }}</th>
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
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->firstname}}</td>
                                    <td>{{$item->lastname}}</td>
                                    <td>
                                        <a href="{{ route('business.employees.show', ['id' => $item->id]) }}">
                                            <button class="btn-sm btn-primary mt-1 mb-1">{{ __('business/labels.table__show_employee') }}</button>
                                        </a>
                                        <form action="{{ route('business.labels.remove_employee_action') }}" method="POST" enctype="multipart/form-data" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn-sm btn-danger mt-1 mb-1">{{ __('business/labels.table__remove_employee') }}</button>
                                            <input name="label_id" type="hidden" value="{{ $label['id'] }}"/>
                                            <input name="employee_id" type="hidden" value="{{ $item->id }}"/>
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
                    <span>{{ __('business/tables.table__found') }} {{ $table->count() }} {{ __('business/tables.table__records') }}.</span>
                    <span>{{ $table->lastPage() }} {{ __('business/tables.table__available_pages') }}.</span>
                </div>
            </div>
        </div>
    </div>
@endsection