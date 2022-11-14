<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'employeeno','name', 'icno', 'email', 'address', 'contactno','educationlevel','fieldstudy','designation','workbase_id','cvno',
    ];

    public function workbase()
    {
        return $this->belongsTo(WorkBase::class);
    }

    public function purchaseorder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }
}
