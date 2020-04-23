@extends('business.layouts.app')

@section('meta_title', __('business/labels.meta_title__all') )
@section('page_title', __('business/labels.page_title__all') )

@section('sidebar')
    @parent
@endsection

@section('content')
    <div class="row">
        <div class="col-12 mb-4">
            <a href="{{ route('business.labels.create') }}">
                <button class="btn-sm btn-secondary">{{ __('business/labels.add') }}</button>
            </a>
            <form action="{{ route('business.labels.delete') }}" method="GET" enctype="multipart/form-data" id="form__mass_delete" class="d-inline m-0 p-0">
                <input name="id" id="mass_selection__ids_delete" type="hidden"/>
                <button id="form__mass_delete_submit" type="submit" class="btn-sm btn-danger">{{ __('business/tables.delete_selected') }}</button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('business/labels.search') }}</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <form action="{{ route('business.labels.all') }}" method="GET" enctype="multipart/form-data" class="col-md-12 row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label>{{ __('business/labels.column_table__label__id') }}</label>
                                <input name="id" type="text" class="form-control" value="{{ app('request')->input('id') }}">
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label>{{ __('business/labels.column_table__label__name') }}</label>
                                <input name="name" type="text" class="form-control" value="{{ app('request')->input('name') }}">
                                <small class="form-text text-muted"></small>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">{{ __('business/labels.search') }}</button>
                                <a href="{{ route('business.labels.all') }}">
                                    <button type="button" class="btn btn-secondary">{{ __('business/labels.clear') }}</button>
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
                            <th>
                                <button onClick="MassSelection.select_all(true)" class="btn-sm btn-secondary mt-1 mb-1">{{ __('business/tables.table__select_all') }}</button>
                                <button onClick="MassSelection.select_all(false)" class="btn-sm btn-secondary mt-1 mb-1">{{ __('business/tables.table__unselect_all') }}</button>
                            </th>
                            <th>{{ __('business/labels.column_table__label__id') }}</th>
                            <th>{{ __('business/labels.column_table__label__name') }}</th>
                            <th>{{ __('business/settings.form__allowed_ips.title') }}</th>
                            <th></th>
                            <th>{{ __('business/tables.table__actions') }}</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>
                                <button onClick="MassSelection.select_all(true)" class="btn-sm btn-secondary mt-1 mb-1">{{ __('business/tables.table__select_all') }}</button>
                                <button onClick="MassSelection.select_all(false)" class="btn-sm btn-secondary mt-1 mb-1">{{ __('business/tables.table__unselect_all') }}</button>
                            </th>
                            <th>{{ __('business/labels.column_table__label__id') }}</th>
                            <th>{{ __('business/labels.column_table__label__name') }}</th>
                            <th>{{ __('business/settings.form__allowed_ips.title') }}</th>
                            <th></th>
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
                                    <td>
                                        <input id="mass_selection__table_checkbox_{{ $item->id }}" data-table-id="{{ $item->id }}" onClick="MassSelection.checkbox({{ $item->id }})" type="checkbox" class="mass-selection-table--table-checkbox"/>
                                    </td>
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->allowed_ips ?? __('business/labels.allowed_all')}}</td>
                                    <td>
                                        <a href="{{ route('qrcode.create', ['data' => url()->route('tinyurl.redirect.label', ['id' => $item->id]), 'width' => '400', 'height' => '400']) }}" target="_blank">
                                            <button class="btn-sm btn-primary mt-1 mb-1">{{ __('business/labels.table__button_qrcode') }}</button>
                                        </a>
                                        <a href="{{ route('business.labels.printa5', ['id' => $item->id]) }}" target="_blank">
                                            <button class="btn-sm btn-primary mt-1 mb-1">{{ __('business/labels.table__button_printa5') }}</button>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('business.labels.show', ['id' => $item->id]) }}">
                                            <button class="btn-sm btn-primary mt-1 mb-1">{{ __('business/tables.table__show') }}</button>
                                        </a>
                                        <a href="{{ route('business.labels.edit', ['id' => $item->id]) }}">
                                            <button class="btn-sm btn-secondary mt-1 mb-1">{{ __('business/tables.table__edit') }}</button>
                                        </a>
                                        <a href="{{ route('business.labels.delete', ['id' => $item->id]) }}">
                                            <button class="btn-sm btn-danger mt-1 mb-1">{{ __('business/tables.table__delete') }}</button>
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

@section('footer_additional')
    @parent
    <input name="id" id="mass_selection__array_ids" type="hidden" value="[]"/>
    <script>
        var MassSelection = {
            checkbox_dom_id : "mass_selection__table_checkbox_",
            checkbox_dom_class :"mass-selection-table--table-checkbox",
            array_dom : "mass_selection__array_ids",
            checkbox_select_all : "mass-selection-table--select-all",
            empty : function() {
                var data = [];
                document.getElementById(this.array_dom).value = JSON.stringify(data);
                var doms = document.getElementsByClassName(this.checkbox_dom_class);
                if (doms) {
                    for (var i=0; i<doms.length; i++) {
                        doms[i].checked = false;
                    }
                }
            },
            checkbox : function(id) {
                if (id == parseInt(id)) {
                    var json_data = document.getElementById(this.array_dom).value;
                    try {
                        var data = JSON.parse(json_data);
                        var found_position = data.indexOf(id);
                        if (found_position > -1) {
                            data.splice(found_position, 1);
                        } else {
                            data.push(id);
                        }
                        for (var i=0; i<data.length; i++) {
                            try {
                                document.getElementById(this.checkbox_dom_id+data[i]).checked = true;
                            } catch(err) {
                                //Silence!
                            }
                        }
                        document.getElementById(this.array_dom).value = JSON.stringify(data);
                        console.log(data);
                    } catch(err) {
                        document.getElementById(this.checkbox_dom_id+id).checked = true;
                        var data = [];
                        data.push(id);
                        document.getElementById(this.array_dom).value = JSON.stringify(data);
                    }
                }
            },
            select_all : function(state) {
                if (state) {
                    var doms = document.getElementsByClassName(this.checkbox_dom_class);
                    if (doms) {
                        for (var i=0; i<doms.length; i++) {
                            this.checkbox(parseInt(doms[i].dataset.tableId));
                        }
                    }
                } else {
                    this.empty();
                }
            }
        };
        var MassDelete = {
            form : "form__mass_delete",
            delete_ids_dom : "mass_selection__ids_delete",
            array_dom : MassSelection.array_dom,
            action : function(e) {
                e.preventDefault();
                e.stopPropagation();
                try {
                    var data = JSON.parse(document.getElementById(this.array_dom).value);
                    if (data.length > 0) {
                        var comma_separated_ids = data.join(",")
                        document.getElementById(this.delete_ids_dom).value = comma_separated_ids;
                        document.getElementById(this.form).submit();
                    }
                } catch(e) {
                    //Silence!
                }
            }
        };
        var EventListeners = {
            do : function() {
                document.getElementById("form__mass_delete_submit").addEventListener("click", function(e){
                    MassDelete.action(e);
                });
            }
        };
        EventListeners.do();
    </script>
@endsection