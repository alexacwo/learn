<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionOption extends Model
{
	 public $table = 'question_options';	
	 	 
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title'];
	
    /**
     * Get the question that owns the option.
     */
    public function test()
    {
        return $this->belongsTo(Test::class);
    }
}
