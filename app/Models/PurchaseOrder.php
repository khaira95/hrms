<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id','workbase_id','PO_number','PO_start', 'PO_end', 'PO_normal_rate','PO_OT_rate'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function workbase()
    {
        return $this->belongsTo(WorkBase::class);
    }
}

