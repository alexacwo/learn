<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'test_id',
		'test_answers'
	];
		
    /**
     * Get the user that owns the test result
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }	
}
