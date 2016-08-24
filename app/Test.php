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
    protected $fillable = [
		'title',
		'date',
		'intro'
	];
	
	/**
	* The attributes that should be mutated to dates.
	*
	* @var array
	*/
    protected $dates = ['date'];

	/**
	* The storage format of the model's date columns.
	*
	* @var string
	*/
    protected $dateFormat = 'd.m.Y';
	
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
	
	/**
     * Get all of the question options for all question for a given test
     */
    public function question_options()
    {
        return $this->hasMany(QuestionOption::class);
    }
}
