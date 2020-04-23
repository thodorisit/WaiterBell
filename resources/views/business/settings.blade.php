@extends('business.layouts.app')

@section('meta_title', __('business/settings.meta_title__index'))
@section('page_title', __('business/settings.meta_title__index'))

@section('sidebar')
    @parent
@endsection

@section('content')
    <div class="row">

        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('business/settings.form__allowed_ips.title') }}</h6>
                    <small class="d-block m-0">{{ __('business/settings.form__allowed_ips.label_small') }}</small>
                </div>
                <div class="card-body">
                    <div class="row">
                        <form action="{{ route('business.settings.allowed_ips_action') }}" method="POST" enctype="multipart/form-data" class="col-12 row">
                            @csrf
                            <div class="form-group col-12">
                                <label class="d-block m-0">{{ __('business/settings.form__allowed_ips.label') }}</label>
                                <small class="d-block m-0">{{ __('business/settings.form__allowed_ips.label_small') }}</small>
                                <input name="allowed_ips" value="{{ $data['business_info']['allowed_ips'] }}" class="mt-1 form-control {{ (!empty(Session::get('form_error')['allowed_ips']) ? "form-error" : "") }}"/>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">{{ __('business/settings.update') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('business/settings.form__name.title') }}</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <form action="{{ route('business.settings.name_action') }}" method="POST" enctype="multipart/form-data" class="col-12 row">
                            @csrf
                            <div class="form-group col-12">
                                <label class="d-block m-0">{{ __('business/settings.form__name.label') }}</label>
                                <small class="d-block m-0">{{ __('business/settings.form__name.label_small') }}</small>
                                <input name="name" value="{{ $data['business_info']['name'] }}" class="mt-1 form-control {{ (!empty(Session::get('form_error')['name']) ? "form-error" : "") }}"/>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">{{ __('business/settings.update') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('business/settings.form__logo.title') }}</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <form action="{{ route('business.settings.logo_action') }}" method="POST" enctype="multipart/form-data" class="col-12 row">
                            @csrf
                            <img src="{{ asset('business-logo/'.$data['business_info']['logo_url']) }}" class="settings-logo"/>
                            <div class="form-group col-12">
                                <label class="d-block m-0">{{ __('business/settings.form__logo.label') }}</label>
                                <small class="d-block m-0">{{ __('business/settings.form__logo.label_small') }}</small>
                                <input name="logo" type="file" class="mt-1 form-control {{ (!empty(Session::get('form_error')['logo']) ? "form-error" : "") }}"/>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">{{ __('business/settings.update') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('business/settings.form__password.title') }}</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <form action="{{ route('business.settings.password_action') }}" method="POST" enctype="multipart/form-data" class="col-12 row">
                            @csrf
                            <div class="form-group col-12">
                                <label class="d-block m-0">{{ __('business/settings.form__password.label') }}</label>
                                <small class="d-block m-0">{{ __('business/settings.form__password.label_small') }}</small>
                                <input name="password" type="password" class="mt-1 form-control {{ (!empty(Session::get('form_error')['password']) ? "form-error" : "") }}"/>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">{{ __('business/settings.update') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('business/settings.form__language.title') }}</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <form action="{{ route('business.settings.default_language_action') }}" method="POST" enctype="multipart/form-data" class="col-12 row">
                            @csrf
                            <div class="form-group col-12">
                                <label class="d-block m-0">{{ __('business/settings.form__language.label') }}</label>
                                <small class="d-block m-0">{{ __('business/settings.form__language.label_small') }}</small>
                                <select name="default_language" class="mt-1 form-control">
                                    @php($default_language_exists = false)
                                    @foreach($data['languages'] as $language)
                                        @if($language['is_default'] == 1)
                                            @php($default_language_exists = true)
                                        @endif
                                        <option value="{{ $language['slug'] }}" {{$language['is_default'] == 1 ? "selected" : ""}}>{{ $language['native_name'] }}</option>
                                    @endforeach
                                    @if(!$default_language_exists)
                                        <option value="-" selected>-</option>
                                    @endif
                                </select>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">{{ __('business/settings.update') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection