<?php

namespace App\Report\Engagement;

use Illuminate\Database\Eloquent\Model;

class UniqueTransactionReport extends Model
{
    protected $table = "unique_transaction_reports";
    protected $fillable = ['year', 'month', 'count', 'file'];
    protected $guarded = ['id', 'created_at', 'updated_at'];
}
