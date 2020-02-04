<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionType extends Model
{
    protected $table = 'transaction_types';
    protected $fillable = ['name', 'is_printable'];
}
