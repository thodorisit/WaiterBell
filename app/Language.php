<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Helpers\Business\BusinessSessionHelper as BusinessSessionHelper;

class Language extends Model {

    protected $table = 'language';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'business_id',
        'name',
        'native_name',
        'slug',
        'is_default'
    ];

    public function scopeIsDefault($query) {
        return $query->where('is_default', '=', 1);
    }

    public function scopeSessionBusinessId($query) {
        return $query->where('business_id', '=', BusinessSessionHelper::id());
    }

    public function business() {
        return $this->belongsTo('App\Business', 'business_id', 'id');
    }
    
}
