<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable= [
        'name',
    ];
    public function users()
    {
        return $this->hasMany(User::class);
    }
    
    public function kpis()
    {
    return $this->hasMany(Kpi::class);
    }


    public function measurements()
    {
        return $this->hasMany(Measurements::class);
    }
}
