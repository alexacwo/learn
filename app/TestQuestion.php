<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestQuestion extends Model
{	
	 public $table = 'test_questions';	
	 
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'type'];

    /**
     * Get the test that owns the test option.
     */
    public function test()
    {
        return $this->belongsTo(Test::class);
    }	
				
	/**
     * Get all of the option for the question.
     */
    public function question_options()
    {
        return $this->hasMany(QuestionOption::class);
    }
}
