<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Helpers\Business\BusinessSessionHelper as BusinessSessionHelper;

class Employee extends Model {
    protected $table = 'employee';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $hidden = [
        'password',
        'pivot',
        'login_token'
    ];

    protected $fillable = [
        'business_id',
        'firstname',
        'lastname',
        'password',
        'login_token',
        'login_token_created',
        'push_notification_token'
    ];

    public function scopeSessionBusinessId($query) {
        return $query->where('business_id', '=', BusinessSessionHelper::id());
    }

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

    public function business() {
        return $this->belongsTo('App\Business', 'business_id', 'id');
    }
    public function labels() {
        return $this->belongsToMany('App\Label', 'pivot_label_employee', 'employee_id', 'label_id')
                    ->using('App\Pivot\LabelEmployee')
                    ->withPivot(['business_id']);
    }
}
