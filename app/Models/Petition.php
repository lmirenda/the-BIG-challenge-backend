<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Petition extends Model
{
    use HasFactory;

    protected $fillable = ['title','description','doctor_id','patient_id','status'];

    protected $with = ['patient', 'doctor'];

    public function doctor()
    {
        return $this->belongsTo(User::class,'id');
    }

    public function patient()
    {
        return $this->belongsTo(User::class,'id');
    }
}
