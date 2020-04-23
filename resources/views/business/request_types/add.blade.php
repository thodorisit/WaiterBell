@extends('business.layouts.app')

@section('meta_title', __('business/request_types.meta_title__add'))
@section('page_title', __('business/request_types.page_title__add'))

@section('sidebar')
    @parent
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('business/request_types.add') }}</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <form action="{{ route('business.request_types.create_action') }}" method="POST" enctype="multipart/form-data" class="col-12 row">
                            @csrf
                            <div class="form-group col-12">
                                <label>{{ __('business/request_types.column_table__name_default') }}</label>
                                <input name="name[default]" type="text" class="form-control {{ (!empty(Session::get('form_error')['name.default']) ? "form-error" : "") }}"/>
                            </div>
                            @foreach ($languages as $key => $value)
                                <div class="form-group col-12">
                                    <label>{{ __('business/request_types.column_table__name_lang') }} - {{ $value['native_name'] . ' (' . $value['slug'] . ')' }}</label>
                                    <input name="name[{{ $value['slug'] }}]" type="text" class="form-control"/>
                                </div>
                            @endforeach
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">{{ __('business/request_types.add') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection