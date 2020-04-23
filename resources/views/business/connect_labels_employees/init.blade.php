@extends('business.layouts.app')

@section('meta_title', __('business/connect_labels_employees.meta_title__init') )
@section('page_title', __('business/connect_labels_employees.page_title__init') )

@section('sidebar')
    @parent
@endsection

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('business/connect_labels_employees.select_employee') }}</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            @if (!empty($data['employee']))
                                <h6 class="d-block">ID: {{ $data['employee']['id'] }}</h6>
                                <h5 class="d-block">{{ $data['employee']['firstname'] . ' ' . $data['employee']['lastname'] }}</h5>
                                <a href="{{ route('business.connect_labels_employees.select_employee', ['label_id' => app('request')->input('label_id')]) }}">
                                    <button class="btn-sm btn-outline-primary">{{ __('business/connect_labels_employees.change_selection') }}</button>
                                </a>
                            @else
                                <a href="{{ route('business.connect_labels_employees.select_employee', ['label_id' => app('request')->input('label_id')]) }}">
                                    <button class="btn-sm btn-outline-primary">{{ __('business/connect_labels_employees.search') }}</button>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('business/connect_labels_employees.select_label') }}</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            @if (!empty($data['label']))
                                <h6 class="d-block">ID: {{ $data['label']['id'] }}</h6>
                                <h5 class="d-block">{{ $data['label']['name'] }}</h5>
                                <a href="{{ route('business.connect_labels_employees.select_label', ['employee_id' => app('request')->input('employee_id')]) }}">
                                    <button class="btn-sm btn-outline-primary">{{ __('business/connect_labels_employees.change_selection') }}</button>
                                </a>
                            @else
                                <a href="{{ route('business.connect_labels_employees.select_label', ['employee_id' => app('request')->input('employee_id')]) }}">
                                    <button class="btn-sm btn-outline-primary">{{ __('business/connect_labels_employees.search') }}</button>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <form action="{{ route('business.connect_labels_employees.init_action') }}" method="POST" enctype="multipart/form-data" class="col-md-12 m-0 p-0">
                @csrf
                <input name="employee_id" type="hidden" value="{{ app('request')->input('employee_id') }}"/>
                <input name="label_id" type="hidden" value="{{ app('request')->input('label_id') }}"/>
                <button class="btn btn-primary">{{ __('business/connect_labels_employees.make_connection') }}</button>
            </form>
        </div>
    </div>

@endsection