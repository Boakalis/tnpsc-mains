<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Log;

class Course extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function test()
    {
        return $this->hasMany(Test::class);
    }


    public function formatedTest()
    {
        return $this->hasMany(Test::class);
    }
}
