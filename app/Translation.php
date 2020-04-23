<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Helpers\Business\BusinessSessionHelper as BusinessSessionHelper;

class Translation extends Model {

    public static $translationAttributes = [
        'translations'
    ];
    
    protected $table = 'translation';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $hidden = [];

    protected $fillable = [
        'business_id',
        'attribute',
        'translations'
    ];

    public $casts = [
        'translations' => 'array',
    ];

    public function scopeSessionBusinessId($query) {
        return $query->where('business_id', '=', BusinessSessionHelper::id());
    }
    
    public function business() {
        return $this->belongsTo('App\Business', 'business_id', 'id');
    }

}
