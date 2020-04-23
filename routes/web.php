<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('business.home');
});

Route::prefix('business')->name('business.')->middleware(['BusinessLocalization', 'BusinessViewSharing'])->group(function () {
    Route::get('/', 'Business\BusinessController@home')->name('home');
    Route::get('login', 'Business\BusinessController@login')->name('login');
    Route::post('login_action', 'Business\BusinessController@login_action')->name('login_action');
    Route::get('logout', 'Business\BusinessController@logout')->name('logout');
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', function(){
            return redirect()->route('business.settings.settings');
        })->name('index');
        Route::get('settings', 'Business\SettingsController@settings')->name('settings');
        Route::post('allowed_ips_action', 'Business\SettingsController@allowed_ips_action')->name('allowed_ips_action');
        Route::post('name_action', 'Business\SettingsController@name_action')->name('name_action');
        Route::post('logo_action', 'Business\SettingsController@logo_action')->name('logo_action');
        Route::post('password_action', 'Business\SettingsController@password_action')->name('password_action');
        Route::post('default_language_action', 'Business\SettingsController@default_language_action')->name('default_language_action');
        Route::post('update_push_token_action', 'Business\SettingsController@update_push_token_action')->name('update_push_token_action');
        
    });
    Route::prefix('connect_labels_employees')->name('connect_labels_employees.')->group(function () {
        Route::get('/', function(){
            return redirect()->route('business.connect_labels_employees.init');
        })->name('index');
        Route::get('init', 'Business\ConnectLabelsEmployeesController@init')->name('init');
        Route::post('init_action', 'Business\ConnectLabelsEmployeesController@init_action')->name('init_action');
        Route::get('select_employee', 'Business\ConnectLabelsEmployeesController@select_employee')->name('select_employee');
        Route::get('select_label', 'Business\ConnectLabelsEmployeesController@select_label')->name('select_label');
    });
    Route::prefix('labels')->name('labels.')->group(function () {
        Route::get('/', function(){
            return redirect()->route('business.labels.all');
        })->name('index');
        Route::get('all', 'Business\LabelsController@all')->name('all');
        Route::get('show', 'Business\LabelsController@show')->name('show');
        Route::get('create', 'Business\LabelsController@create')->name('create');
        Route::post('create_action', 'Business\LabelsController@create_action')->name('create_action');
        Route::get('edit', 'Business\LabelsController@edit')->name('edit');
        Route::post('edit_action', 'Business\LabelsController@edit_action')->name('edit_action');
        Route::post('remove_employee_action', 'Business\ConnectLabelsEmployeesController@remove_employee_action')->name('remove_employee_action');
        Route::get('delete', 'Business\LabelsController@delete')->name('delete');
        Route::get('printa5', 'Business\LabelsController@printa5')->name('printa5');
    });
    Route::prefix('employees')->name('employees.')->group(function () {
        Route::get('/', function(){
            return redirect()->route('business.employees.all');
        })->name('index');
        Route::get('all', 'Business\EmployeesController@all')->name('all');
        Route::get('show', 'Business\EmployeesController@show')->name('show');
        Route::get('create', 'Business\EmployeesController@create')->name('create');
        Route::post('create_action', 'Business\EmployeesController@create_action')->name('create_action');
        Route::get('edit', 'Business\EmployeesController@edit')->name('edit');
        Route::post('edit_action', 'Business\EmployeesController@edit_action')->name('edit_action');
        Route::post('revoke_login_token', 'Business\EmployeesController@revoke_login_token')->name('revoke_login_token');
        Route::post('revoke_push_token', 'Business\EmployeesController@revoke_push_token')->name('revoke_push_token');
        Route::get('delete', 'Business\EmployeesController@delete')->name('delete');
    });
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', function(){
            return redirect()->route('business.notifications.all');
        })->name('index');
        Route::get('all', 'Business\NotificationsController@all')->name('all');
        Route::get('delete', 'Business\NotificationsController@delete')->name('delete');
        Route::post('complete_state_action', 'Business\NotificationsController@complete_state_action')->name('complete_state_action');
    });
    Route::prefix('request_types')->name('request_types.')->group(function () {
        Route::get('/', function(){
            return redirect()->route('business.request_types.all');
        })->name('index');
        Route::get('all', 'Business\RequestTypesController@all')->name('all');
        Route::get('create', 'Business\RequestTypesController@create')->name('create');
        Route::post('create_action', 'Business\RequestTypesController@create_action')->name('create_action');
        Route::get('edit', 'Business\RequestTypesController@edit')->name('edit');
        Route::post('edit_action', 'Business\RequestTypesController@edit_action')->name('edit_action');
        Route::get('delete', 'Business\RequestTypesController@delete')->name('delete');
    });
    Route::prefix('languages')->name('languages.')->group(function () {
        Route::get('/', function(){
            return redirect()->route('business.languages.all');
        })->name('index');
        Route::get('all', 'Business\LanguagesController@all')->name('all');
        Route::get('create', 'Business\LanguagesController@create')->name('create');
        Route::post('create_action', 'Business\LanguagesController@create_action')->name('create_action');
        Route::get('delete', 'Business\LanguagesController@delete')->name('delete');
    });
    Route::prefix('translations')->name('translations.')->group(function () {
        Route::get('/', function(){
            return redirect()->route('business.translations.all');
        })->name('index');
        Route::get('all', 'Business\TranslationsController@all')->name('all');
        Route::get('edit', 'Business\TranslationsController@edit')->name('edit');
        Route::post('edit_action', 'Business\TranslationsController@edit_action')->name('edit_action');
    });
});

Route::prefix('customer')->name('customer.')->middleware(['CustomerLocalization'])->group(function () {
    Route::get('/', function(){
        return redirect()->route('customer.home');
    })->name('index');
    Route::get('home/{id?}', 'Customer\CustomerController@home')->name('home');
    Route::post('request_action', 'Customer\CustomerController@request_action')->name('request_action');
    Route::get('success', 'Customer\CustomerController@success')->name('success');
    Route::get('error', 'Customer\CustomerController@error')->name('error');
    Route::get('not_found', 'Customer\CustomerController@not_found')->name('not_found');
});

Route::prefix('employee')->name('employee.')->middleware(['EmployeeLocalization', 'EmployeeViewSharing'])->group(function () {
    Route::get('/', function(){
        return redirect()->route('employee.home');
    })->name('index');
    Route::get('login', 'Employee\EmployeeController@login')->name('login');
    Route::post('login_action', 'Employee\EmployeeController@login_action')->name('login_action');
    Route::get('logout', 'Employee\EmployeeController@logout')->name('logout');
    Route::get('home', 'Employee\EmployeeController@home')->name('home');
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', function(){
            return redirect()->route('employee.notifications.all');
        })->name('index');
        Route::get('all', 'Employee\NotificationsController@all')->name('all');
        Route::post('complete_state_action', 'Employee\NotificationsController@complete_state_action')->name('complete_state_action');
    });
    Route::prefix('labels')->name('labels.')->group(function () {
        Route::get('/', function(){
            return redirect()->route('employee.labels.all');
        })->name('index');
        Route::get('all', 'Employee\LabelsController@all')->name('all');
    });
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::post('update_push_token_action', 'Employee\SettingsController@update_push_token_action')->name('update_push_token_action');
    });
});

Route::prefix('master')->name('master.')->group(function () {
    Route::get('md5', 'Master\MasterController@md5')->name('md5');
    Route::get('create_business', 'Master\MasterController@create_business')->name('create_business');
    Route::get('delete_business', 'Master\MasterController@delete_business')->name('delete_business');
});

Route::get('qrcode', 'QrCodeController@create')->name('qrcode.create');
Route::get('n/{id?}', 'RedirectController@notificationOpenUrl')->name('helper.redirect.notification');
Route::get('{id?}', 'RedirectController@tinyUrlRedirect')->name('tinyurl.redirect.label');

Route::fallback(function() {
    abort(404);
});
