<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title'];
		
    /**
     * Get the user that owns the test.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }	
			
	/**
     * Get all of the test questions for the test.
     */
    public function test_questions()
    {
        return $this->hasMany(TestQuestion::class);
    }
}
