<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Helpers\Business\BusinessSessionHelper as BusinessSessionHelper;
use App\Helpers\NotificationHelper as NotificationHelper;

class Notification extends Model {
    protected $table = 'notification';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $hidden = [];

    protected $fillable = [
        'business_id',
        'label_id',
        'title',
        'body',
        'icon',
        'open_url',
        'state'
    ];

    public function scopeFilterIds($query, $data = array()) {
        if (count($data) > 0) {
            return $query->whereIn('id', $data);
        }
    }

    public function scopeFilterTitle($query, $data) {
        if ($data) {
            return $query->where('title', 'LIKE', '%'.$data.'%');
        }
    }

    public function scopeFilterBody($query, $data) {
        if ($data) {
            return $query->where('body', 'LIKE', '%'.$data.'%');
        }
    }

    public function scopeFilterDateFrom($query, $data) {
        if ($data) {
            return $query->where('created_at', '>=', $data);
        }
    }

    public function scopeFilterDateTo($query, $data) {
        if ($data) {
            return $query->where(\DB::raw('CAST(created_at as DATE)'), '<=', $data);
        }
    }

    public function scopeFilterState($query, $data) {
        if (NotificationHelper::is_valid_state_search($data)) {
            if ($data != 9) {
                return $query->where('state', $data);
            }
        } else {
            return $query->where('state', '0');
        }
    }

    public function scopeOrderByDate($query, $data) {
        if ($data == 'desc' || $data == 'asc') {
            return $query->orderBy('created_at', $data);
        } else {
            return $query->orderBy('created_at', 'desc');
        }
    }

    public function scopeHasLabelIds($query, $data = array(), $ignore_if_empty = true) {
        if ($ignore_if_empty) {
            if (count($data) > 0) {
                return $query->whereIn('label_id', $data);
            }
        } else {
            return $query->whereIn('label_id', $data);
        }
    }

    public function scopeSessionBusinessId($query) {
        return $query->where('business_id', '=', BusinessSessionHelper::id());
    }

    public function label() {
        return $this->belongsTo('App\Label', 'label_id', 'id');
    }

    public function business() {
        return $this->belongsTo('App\Business', 'business_id', 'id');
    }

}
