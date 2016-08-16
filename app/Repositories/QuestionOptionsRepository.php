<?php

namespace App\Repositories;

use App\Question;

class TestQuestionsRepository
{
    /**
     * Get all of the question options for a given question
     *
     * @param  Question $question
     * @return Collection
     */
    public function forQuestion(Question $question)
    {
        return $test->question_options()
                    ->orderBy('created_at', 'asc')
                    ->get();
    }
}