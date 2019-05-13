<?php

namespace Tests\Feature;

use App\Http\Controllers\UserController;
use App\Http\Requests\UserEdit;
use App\Http\Requests\UserSubmit;
use App\User;
use Illuminate\Http\Request;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
{

    /** @test */
    public function is_users_home_page_correctly_displayed()
    {
        $response = $this->get('/backoffice/users');

        $response->assertStatus(200);
    }
    /** @test */
    public function is_users_edit_page_correctly_displayed()
    {
        $user = new User();
        $user->username = "test";
        $user->save();
        $response = $this->get('/backoffice/users/edit/' . $user->id );

        $response->assertStatus(200);
        User::destroy($user->id);
    }
    /** @test */
    public function is_users_add_page_correctly_displayed()
    {
        $response = $this->get('/backoffice/users/add');

        $response->assertStatus(200);
    }

    /** @test */
    public function is_update_script_working_correctly(){
        $user = new User();
        $user->username = "test";
        $user->save();
        $id = $user->id;

        $request = UserEdit::create('/backoffice/users/edit/' . $id . '/update', 'POST', [
            'id' => $id,
            'username' => 'test_updated',
        ]);
        $controller = new UserController();

        $response = $controller->update($request);

        $this->assertEquals("test_updated", User::find($id)->username);
        $this->assertEquals(302, $response->getStatusCode());
        User::destroy($id);
    }

    /**@test*/
    public function is_update_script_sending_404_when_wrong_id_given(){
        $id = 0;
        $request = UserEdit::create('/backoffice/users/edit/' . $id . '/update', 'POST', [
            'id' => $id,
        ]);
        $controller = new UserController();

        $response = $controller->update($request);

        $this->assertEquals(404, $response->getStatusCode());
    }

    /** @test */
    public function is_delete_script_working_correctly()
    {
        $user = new User();
        $user->username = "test_delete_script";
        $user->save();

        $this->assertEquals(1, User::where('id',$user->id)->count());

        $request = Request::create('/backoffice/users/delete/' . $user->id, 'GET', [
            'id' => $user->id,
        ]);

        $controller = new UserController($request);

        $response = $controller->delete($request);
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals(0, User::where('id',$user->id)->count());
    }

    /**@test*/
    public function is_delete_script_sending_404_when_wrong_id_given()
    {
        $id = 0;
        $request = UserEdit::create('/backoffice/users/edit/' . $id . '/update', 'GET', [
            'id' => $id,
        ]);
        $controller = new UserController();

        $response = $controller->delete($request);

        $this->assertEquals(404, $response->getStatusCode());
    }

    /** @test */
    public function is_user_info_page_correctly_displayed(){
        $user = new User();
        $user->username = "test_userinfo_page";
        $user->save();


        $response = $this->get('/backoffice/users/' . $user->id);

        $response->assertStatus(200);
        User::destroy($user->id);
    }
    /** @test */
    public function is_submit_method_working_correctly(){
        $request = UserSubmit::create('/backoffice/post-user', 'POST', [
            'username' => 'test_adduser_method',
            'password' => bcrypt('Super'),
            'email' => 'test@test.com',
            'phone_number' => '1234567890',
            'name' => 'test',
            'surname' => 'test',
            'date_of_birth' => '2019-05-01',
        ]);

        $controller = new UserController();

        $response = $controller->submit($request);

        $this->assertEquals(302, $response->getStatusCode());
        User::where('username', 'test_adduser_method')->delete();
    }

    /** @test */
    public function is_submitAPI_method_working_correctly(){
        $response = $this->json('POST','/api/users/add',  [
            'username' => 'test_adduser',
            'password' => 'Super',
            'password_confirmation' => 'Super',
            'email' => 'test@test.com',
            'phone_number' => '1234567890',
            'name' => 'test',
            'surname' => 'test',
            'date_of_birth' => '2019-05-01',
        ]);
        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'user' => [
                    'username' => 'test_adduser',
                ]
            ]);

        User::where('username', 'test_adduser')->delete();
    }

    /** @test */
    public function is_submitAPI_method_display_errors_when_bad_data_given(){
        $response = $this->json('POST','/api/users/add',  [
            'username' => 'test_adduser_dipsajdhsanjdnsandlasn',
            'password' => 'Super',
            'password_confirmation' => 'Super',
            'email' => 'test@test.com',
            'phone_number' => '1234567890',
            'name' => 'test',
            'surname' => 'test',
            'date_of_birth' => '2019-05-01',
        ]);
        $response
            ->assertStatus(422);
    }

}
