<?php

namespace Tests\Unit;

use App\Proposition;
use App\Question;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QuestionTest extends TestCase
{
    public function is_question_created_and_deleted_correctly(){
        $question = new Question();
        $question->label = "test";
        $question->points = 20;
        $question->type_id = 1;
        $question->tag_id = 1;


        $this->assertTrue($question->saveOrFail());
        $id = $question->id;
        $this->assertEquals(1, Question::where('id', $id)->count());


        $this->assertEquals(1, Question::destroy($id));
        $this->assertEquals(0, Question::where('id', $id)->count());
    }

    /** @test */
    public function is_question_updated_correctly(){
        $question = new Question();
        $question->label = "test_update";
        $question->points = 20;
        $question->type_id = 1;
        $question->tag_id = 1;
        $question->save();

        $question->label = "test_update1";
        $question->save();
        $id = $question->id;

        $this->assertEquals("test_update1", Question::find($id)->label);
        Question::destroy($id);
    }
    /** @test */
    public function are_propositions_deleted_when_questions_also_deleted(){
        $question = new Question();
        $question->label = "test_delete";
        $question->points = 20;
        $question->type_id = 1;
        $question->tag_id = 1;
        $question->save();
        $id = $question->id;
        for($i = 0; $i < 4; $i++){
            $proposition = new Proposition();
            $proposition->label = $i;
            $proposition->is_right_answer = 0;
            $proposition->question_id = $id;
            $proposition->save();
        }

        $this->assertEquals(4, Proposition::where('question_id', $id)->count());
        Question::destroy($id);
        $this->assertEquals(0, Proposition::where('question_id', $id)->count());
    }
}
