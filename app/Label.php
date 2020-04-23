<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Helpers\Business\BusinessSessionHelper as BusinessSessionHelper;

class Label extends Model {
    protected $table = 'label';
    protected $primaryKey = 'id';
    public $timestamps = false;

    //Business::with(['employees.labels'])->get()->toArray() hide pivot in "label"
    protected $hidden = ['pivot'];

    protected $fillable = [
        'business_id',
        'name',
        'allowed_ips'
    ];

    public function scopeSessionBusinessId($query) {
        return $query->where('business_id', '=', BusinessSessionHelper::id());
    }

    public function business() {
        return $this->belongsTo('App\Business', 'business_id', 'id');
    }
    public function employees() {
        return $this->belongsToMany('App\Employee', 'pivot_label_employee', 'label_id', 'employee_id')
                    ->using('App\Pivot\LabelEmployee')
                    ->withPivot('business_id');
    }
    public function notifications() {
        return $this->hasMany('App\Notification', 'label_id', 'id');
    }
}
