<?php

namespace App\Report\Engagement;

use Illuminate\Database\Eloquent\Model;

class Engagement extends Model
{
    protected $table = "engagements";
    protected $fillable = ['counts', 'files'];
    protected $guarded = ['id', 'created_at', 'updated_at'];
}
