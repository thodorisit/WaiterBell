@extends('business.layouts.app')

@section('meta_title', __('business/labels.meta_title__add'))
@section('page_title', __('business/labels.page_title__add'))

@section('sidebar')
    @parent
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('business/labels.add') }}</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <form action="{{ route('business.labels.create_action') }}" method="POST" enctype="multipart/form-data" class="col-12 row" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group col-12">
                                <label>{{ __('business/labels.column_table__label__name') }}</label>
                                <input name="name" type="text" class="form-control {{ (!empty(Session::get('form_error')['name']) ? "form-error" : "") }}"/>
                            </div>
                            <div class="form-group col-12">
                                <label>{{ __('business/settings.form__allowed_ips.title') }}</label>
                                <small>({{ __('business/settings.form__allowed_ips.label_small') }})</small>
                                <input placeholder="All" name="allowed_ips" type="text" class="form-control {{ (!empty(Session::get('form_error')['ips']) ? "form-error" : "") }}"/>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">{{ __('business/labels.add') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection