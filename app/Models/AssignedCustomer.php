<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignedCustomer extends Model
{
    //
    protected $fillable= [
        'created_by',
        'employee_id',
        'customer_id',
    ];
}
