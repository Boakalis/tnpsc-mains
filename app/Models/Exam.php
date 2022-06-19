<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public static function boot()
{
    parent::boot();

    // registering a callback to be executed upon the creation of an activity AR
    static::creating(function($exam) {

        // produce a slug based on the activity title
        $slug = \Str::slug($exam->name);

        // check to see if any other slugs exist that are the same & count them
        $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();

        // if other slugs exist that are the same, append the count to the slug
        $exam->slug = $count ? "{$slug}-{$count}" : $slug;

    });

}




}
