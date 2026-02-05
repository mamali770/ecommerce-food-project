<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    protected $table = 'transactions';
    protected $guarded = [];

    public function scopeGetData($query, $status)
    {
        return $query->where('created_at', '>=', verta()->subMonths(12)->toCarbon())->where('status', $status)->orderByDesc('created_at')->get();
    }
}
