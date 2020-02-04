<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionReport extends Model
{
    protected $connection = 'reporting-mysql';

    protected $guarded = ['id'];
}
