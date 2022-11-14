<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkBase extends Model
{
    protected $fillable = ['name', 'address', 'remarks'];
    protected $table = 'workbases';
}
