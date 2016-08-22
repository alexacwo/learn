<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
	
	/**
     * Get all of the tasks for the user.
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
	
		
	/**
     * Get all of the tests for the user.
     */
    public function tests()
    {
        return $this->hasMany(Test::class);
    }
	
			
	/**
     * Get all of the test results for the user
     */
    public function test_results()
    {
        return $this->hasMany(TestResult::class);
    }
}
