<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Helpers\Business\BusinessSessionHelper as BusinessSessionHelper;

class Business extends Model {
    protected $table = 'business';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $hidden = [
        'username',
        'password',
        'state',
        'account_type',
        'login_token',
    ];

    protected $fillable = [
        'username',
        'password',
        'name',
        'logo_url',
        'email',
        'telephone',
        'address',
        'allowed_ips',
        'state',
        'account_type',
        'login_token',
        'login_token_created',
        'push_notification_token'
    ];

    public function scopeIsLogedIn($query) {
        $query->where([
            ['login_token', '!=', '']
        ]);
        $query->whereNotNull('login_token');
        return $query;
    }

    public function scopeHasPushToken($query) {
        $query->where([
            ['push_notification_token', '!=', '']
        ]);
        $query->whereNotNull('push_notification_token');
        return $query;
    }

    public function scopeSessionBusinessId($query) {
        return $query->where('id', '=', BusinessSessionHelper::id());
    }

    public function employees() {
        return $this->hasMany('App\Employee', 'business_id', 'id');
    }

    public function labels() {
        return $this->hasMany('App\Label', 'business_id', 'id');
    }

    public function languages() {
        return $this->hasMany('App\Language', 'business_id', 'id');
    }

    public function notifications() {
        return $this->hasMany('App\Notification', 'business_id', 'id');
    }

    public function requestTypes() {
        return $this->hasMany('App\RequestTypes', 'business_id', 'id');
    }

}
