<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'icon', 'company_id'
    ];

    public function employees() 
    {
        return $this->hasMany(Employee::class);
    }

    public function companies()
    {
        return $this->belongsTo(Company::class);
    }
}
