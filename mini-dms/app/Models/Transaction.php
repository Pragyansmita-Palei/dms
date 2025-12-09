<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['order_id','payment_id','order_id_razorpay','signature','amount','status','meta'];
    protected $casts = ['meta' => 'array'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
