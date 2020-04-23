<?php

namespace App\Pivot;

use Illuminate\Database\Eloquent\Relations\Pivot;

class LabelEmployee extends Pivot {
    protected $table = 'pivot_label_employee';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'business_id',
        'label_id',
        'employee_id'
    ];
}
