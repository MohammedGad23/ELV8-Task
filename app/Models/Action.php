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
    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


}
