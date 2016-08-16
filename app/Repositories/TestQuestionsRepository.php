<?php

namespace App\Repositories;

use App\User;
use App\Test;

class TestQuestionsRepository
{
    /**
     * Get all of the test questions for a given test.
     *
     * @param  Test $test
     * @return Collection
     */
    public function forTest(Test $test)
    {
        return $test->test_questions()
                    ->orderBy('created_at', 'asc')
                    ->get();
    }
}