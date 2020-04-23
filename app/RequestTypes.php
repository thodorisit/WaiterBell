<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Helpers\Business\BusinessSessionHelper as BusinessSessionHelper;

class RequestTypes extends Model {

    public static $translationAttributes = [
        'name'
    ];
    
    protected $table = 'request_type';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $hidden = [];

    protected $fillable = [
        'business_id',
        'name'
    ];

    public $casts = [
        'name' => 'array',
    ];

    public function scopeSessionBusinessId($query) {
        return $query->where('business_id', '=', BusinessSessionHelper::id());
    }
    
    public function business() {
        return $this->belongsTo('App\Business', 'business_id', 'id');
    }

}
