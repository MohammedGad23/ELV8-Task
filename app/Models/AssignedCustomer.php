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

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
