@extends('business.layouts.app')

@section('meta_title', __('business/home.meta_title__homepage'))
@section('page_title', __('business/home.page_title__homepage'))

@section('sidebar')
    @parent
@endsection

@section('content')
    <div class="row">

        <div class="col-lg-4 col-md-6 mt-2">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">{{ __('business/home.employees') }}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $info['count_employees'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="col-lg-4 col-md-6 mt-2">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">{{ __('business/home.labels') }}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $info['count_labels'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tags fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="col-lg-4 col-md-6 mt-2">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">{{ __('business/home.languages') }}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $info['count_languages'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-language fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row mt-4">

        <div class="col-lg-6">

            <div class="card mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('business/home.business.id') }}</h6>
                </div>
                <div class="card-body">
                    <div class="row ml-1">
                        <div class="text-lg font-weight-bold text-primary">{{$info['business_id']}}</div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('business/home.notifications.label') }}</h6>
                </div>
                <div class="card-body">
                    <div class="row">

                        <div class="col-lg-12 card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">{{ __('business/home.notifications.pending') }}</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $info['count_notifications'][0]['pending'] }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <a href="{{ route('business.notifications.all',['state' => '0']) }}" class="btn btn-secondary btn-circle btn-md">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 mt-3 card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">{{ __('business/home.notifications.completed') }}</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $info['count_notifications'][0]['completed'] }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <a href="{{ route('business.notifications.all',['state' => '1']) }}" class="btn btn-secondary btn-circle btn-md">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('business/settings.form__webpush.title') }}</h6>
                </div>
                <div class="card-body">
                    @if ($info['web_push_token'])
                        <div class="row ml-1">
                            <form action="{{ route('business.settings.update_push_token_action') }}" method="POST" enctype="multipart/form-data" class="col-12 row" enctype="multipart/form-data">
                                @csrf
                                <h6>{{ __('business/settings.form__webpush.unsubscribe_label') }}</h6>
                                <input type="hidden" name="reason" value="unsubscribe"/>
                                <button type="submit" class="btn btn-primary">{{ __('business/settings.form__webpush.unsubscribe_button') }}</button>
                            </form>
                        </div>
                    @else
                        <div class="row ml-1">
                            <h6>{{ __('business/settings.form__webpush.subscribe_label') }}</h6>
                            <form action="{{ route('business.settings.update_push_token_action') }}" method="POST" enctype="multipart/form-data" class="col-12 row" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" id="__web_push_device_id" name="push_token"/>
                                <input type="hidden" name="reason" value="subscribe"/>
                                <button type="submit" class="btn btn-primary">{{ __('business/settings.form__webpush.subscribe_button') }}</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('business/home.ip.title') }}</h6>
                </div>
                <div class="card-body">
                    <div class="row ml-1">
                        <div class="text-lg font-weight-bold text-primary">{{$info['ip_address']}}</div>
                    </div>
                </div>
            </div>

        </div>

    </div>

@endsection