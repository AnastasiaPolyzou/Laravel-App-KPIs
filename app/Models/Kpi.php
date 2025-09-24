<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Kpi extends Model
{

    use HasFactory;
    protected $fillable = ['company_id', 'name', 'unit'];
    
    
    public function company()
    {
    return $this->belongsTo(Company::class);
    }



    public function measurements()
    {
        return $this->hasMany(Measurements::class);
    }
}
