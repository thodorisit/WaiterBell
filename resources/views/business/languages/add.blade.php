@extends('business.layouts.app')

@section('meta_title', __('business/languages.meta_title__add'))
@section('page_title', __('business/languages.page_title__add'))

@section('sidebar')
    @parent
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('business/languages.add') }}</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <form action="{{ route('business.languages.create_action') }}" method="POST" enctype="multipart/form-data" class="col-12 row" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group col-12">
                                <label>{{ __('business/languages.select_language') }}</label>
                                <select name="language" type="text" class="form-control">
                                    @foreach ($data['languages'] as $slug => $lang)
                                        @if (array_key_exists('exists', $lang))
                                            <option value="{{ $slug }}" disabled>{{ $lang['nativeName'] }}</option>
                                        @else
                                            <option value="{{ $slug }}">{{ $lang['nativeName'] }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">{{ __('business/languages.select_one_of_the_available_languages') }}</small>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">{{ __('business/languages.add') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection