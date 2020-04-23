@extends('business.layouts.app')

@section('meta_title', __('business/translations.meta_title__edit'))
@section('page_title', __('business/translations.page_title__edit'))

@section('sidebar')
    @parent
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('business/translations.edit') }}</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <form action="{{ route('business.translations.edit_action') }}" method="POST" enctype="multipart/form-data" class="col-12 row" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group col-12">
                                <label>{{ $data['item']['attribute'] }}</label>
                                <input value="{{ $data['item']['translations']['default'] }}" name="translations[default]" type="text" class="form-control {{ (!empty(Session::get('form_error')['translations.default']) ? "form-error" : "") }}"/>
                            </div>
                            @foreach ($languages as $key => $value)
                                <div class="form-group col-12">
                                    <label>{{ $data['item']['attribute'] }} - {{ $value['native_name'] . ' (' . $value['slug'] . ')' }}</label>
                                    <input value="{{ $data['item']['translations'][$value['slug']] ?? "" }}" name="translations[{{ $value['slug'] }}]" type="text" class="form-control"/>
                                </div>
                            @endforeach
                            <input name="id" type="hidden" value="{{ app('request')->input('id') }}"/>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">{{ __('business/translations.save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection