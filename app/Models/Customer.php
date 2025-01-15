<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
    protected $fillable =[
        'name',
        'email',
        'phone',
        'gender',
        'created_by',
    ];
    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by');
    }
    public function actions(){
        return $this->hasMany(Action::class, 'customer_id');
    }
}
