@extends('business.layouts.app')

@section('meta_title', __('business/connect_labels_employees.meta_title__employees') )
@section('page_title', __('business/connect_labels_employees.page_title__employees') )

@section('sidebar')
    @parent
@endsection

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('business/employees.search') }}</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <form action="{{ route('business.connect_labels_employees.select_employee') }}" method="GET" enctype="multipart/form-data" class="col-md-12 row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label>{{ __('business/employees.column_table__id') }}</label>
                                <input name="id" type="text" class="form-control" placeholder="" value="{{ app('request')->input('id') }}">
                                <small class="form-text text-muted"></small>
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label>{{ __('business/employees.column_table__firstname') }}</label>
                                <input name="firstname" type="text" class="form-control" placeholder="" value="{{ app('request')->input('firstname') }}">
                                <small class="form-text text-muted"></small>
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label>{{ __('business/employees.column_table__lastname') }}</label>
                                <input name="lastname" type="text" class="form-control" placeholder="" value="{{ app('request')->input('lastname') }}">
                                <small class="form-text text-muted"></small>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">{{ __('business/employees.search') }}</button>
                                <a href="{{ route('business.connect_labels_employees.select_employee') }}">
                                    <button type="button" class="btn btn-secondary">{{ __('business/employees.clear') }}</button>
                                </a>
                            </div>
                            <input type="hidden" name="label_id" value="{{ app('request')->input('label_id') }}"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>{{ __('business/employees.column_table__id') }}</th>
                            <th>{{ __('business/employees.column_table__firstname') }}</th>
                            <th>{{ __('business/employees.column_table__lastname') }}</th>
                            <th>{{ __('business/tables.table__actions') }}</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>{{ __('business/employees.column_table__id') }}</th>
                            <th>{{ __('business/employees.column_table__firstname') }}</th>
                            <th>{{ __('business/employees.column_table__lastname') }}</th>
                            <th>{{ __('business/tables.table__actions') }}</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @if($table->total() == '0')
                            <tr>
                                <td colspan="3">{{ __('business/tables.table__no_available_data') }}</td>
                            </tr>
                        @else
                            @foreach($table as $item)
                                <tr>
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->firstname}}</td>
                                    <td>{{$item->lastname}}</td>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a href="{{ route('business.connect_labels_employees.init', ['employee_id' => $item->id, 'label_id' => app('request')->input('label_id')]) }}">
                                                    <button class="btn-sm btn-primary mt-1 mb-1">{{ __('business/connect_labels_employees.select_employee') }}</button>
                                                </a>
                                                <a href="{{ route('business.employees.show', ['id' => $item->id]) }}">
                                                    <button class="btn-sm btn-outline-primary mt-1 mb-1">{{ __('business/tables.table__show') }}</button>
                                                </a>
                                            </div>
                                        </div>
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