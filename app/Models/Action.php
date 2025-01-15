<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    //

    protected $fillable =[
        'action_type',
        'result',
        'created_by',
        'customer_id',
    ];
}
