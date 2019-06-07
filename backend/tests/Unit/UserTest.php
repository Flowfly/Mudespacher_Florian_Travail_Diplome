<?php
/* Florian Mudespacher
 * Quiz interactif - Diploma work
 * CFPT - T.IS-E2A - 2019
 */

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class UserTest extends TestCase
{
    /** @test */
    public function is_user_created_and_deleted_correctly(){
        $user = new User();
        $user->username = "test_user_creation";
        $user->password = bcrypt("test");
        $user->email = "test@test.com";
        $user->phone_number = "123456789";
        $user->name = "Test";
        $user->surname = "Test";
        $user->date_of_birth = "2019-05-01";


        $this->assertTrue($user->saveOrFail());
        $id = $user->id;
        $this->assertEquals($id, User::find($id)->id);


        $this->assertEquals(1, User::destroy($id));
        $this->assertEquals(0, User::where('id', $id)->count());
    }

    /** @test */
    public function is_user_updated_correctly(){
        $user = new User();
        $user->username = "test_update";
        $user->save();

        $user->username = "test_update1";
        $user->save();
        $id = $user->id;

        $this->assertEquals("test_update1", User::find($id)->username);
        User::destroy($id);
    }
}
