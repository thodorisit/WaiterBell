@extends('business.layouts.app')

@section('meta_title', __('business/translations.meta_title__all') )
@section('page_title', __('business/translations.page_title__all') )

@section('sidebar')
    @parent
@endsection

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('business/translations.search') }}</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <form action="{{ route('business.translations.all') }}" method="GET" enctype="multipart/form-data" class="col-md-12 row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label>{{ __('business/translations.column_table__id') }}</label>
                                <input name="id" type="text" class="form-control" value="{{ app('request')->input('id') }}">
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label>{{ __('business/translations.column_table__label__attribute') }}</label>
                                <input name="attribute" type="text" class="form-control" value="{{ app('request')->input('attribute') }}">
                                <small class="form-text text-muted"></small>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">{{ __('business/translations.search') }}</button>
                                <a href="{{ route('business.translations.all') }}">
                                    <button type="button" class="btn btn-secondary">{{ __('business/translations.clear') }}</button>
                                </a>
                            </div>
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
                            <th>{{ __('business/translations.column_table__id') }}</th>
                            <th>{{ __('business/translations.column_table__label__attribute') }}</th>
                            <th>{{ __('business/translations.column_table__label__default_translation') }}</th>
                            <th>{{ __('business/tables.table__actions') }}</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>{{ __('business/translations.column_table__id') }}</th>
                            <th>{{ __('business/translations.column_table__label__attribute') }}</th>
                            <th>{{ __('business/translations.column_table__label__default_translation') }}</th>
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
                                    <td>{{$item->attribute}}</td>
                                    <td>{{$item->translations['default']}}</td>
                                    <td>
                                        <a href="{{ route('business.translations.edit', ['id' => $item->id]) }}">
                                            <button class="btn-sm btn-secondary mt-1 mb-1">{{ __('business/translations.edit') }}</button>
                                        </a>
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