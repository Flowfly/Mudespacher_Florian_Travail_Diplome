<?php
/* Florian Mudespacher
 * Quiz interactif - Diploma work
 * CFPT - T.IS-E2A - 2019
 */

namespace Tests\Unit;

use App\Answer;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AnswerTest extends TestCase
{

    /* @test */
    public function is_answer_inserted_and_deleted_correctly(){
        $answer = new Answer();
        $user = new User();
    }
}
