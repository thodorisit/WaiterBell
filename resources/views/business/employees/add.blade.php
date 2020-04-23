@extends('business.layouts.app')

@section('meta_title', __('business/employees.meta_title__add'))
@section('page_title', __('business/employees.page_title__add'))

@section('sidebar')
    @parent
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('business/employees.add') }}</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <form action="{{ route('business.employees.create_action') }}" method="POST" enctype="multipart/form-data" class="col-12 row" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group col-12">
                                <label>{{ __('business/employees.column_table__firstname') }}</label>
                                <input name="firstname" type="text" class="form-control {{ (!empty(Session::get('form_error')['firstname']) ? "form-error" : "") }}" value="{{ old('firstname') }}"/>
                            </div>
                            <div class="form-group col-12">
                                <label>{{ __('business/employees.column_table__lastname') }}</label>
                                <input name="lastname" type="text" class="form-control {{ (!empty(Session::get('form_error')['lastname']) ? "form-error" : "") }}" value="{{ old('lastname') }}"/>
                            </div>
                            <div class="form-group col-12">
                                <label>{{ __('business/employees.column_table__password') }}</label>
                                <input name="password" type="text" class="form-control {{ (!empty(Session::get('form_error')['password']) ? "form-error" : "") }}" value="{{ old('password') }}"/>
                                <small>{{ __('business/employees.column_table__password__explanation') }} </small>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">{{ __('business/employees.add') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection