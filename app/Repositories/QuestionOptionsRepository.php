<?php

namespace App\Repositories;

use App\Test;

class QuestionOptionsRepository
{
    /**
     * Get all of the question options for all question for a given test
     *
     * @param  Test $test
     * @return Collection
     */
    public function forTest(Test $test)
    {
        return $test->question_options()
                    ->orderBy('created_at', 'asc')
                    ->get();
    }
}