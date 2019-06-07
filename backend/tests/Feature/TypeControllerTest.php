<?php
/* Florian Mudespacher
 * Quiz interactif - Diploma work
 * CFPT - T.IS-E2A - 2019
 */

namespace Tests\Feature;

use App\Http\Controllers\TypeController;
use App\Http\Requests\TypeEdit;
use App\Http\Requests\TypeSubmit;
use App\Type;
use Illuminate\Http\Request;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TypeControllerTest extends TestCase
{
    /** @test */
    public function is_submit_method_working_correctly(){
        $request = TypeSubmit::create('/backoffice/post-type', 'POST', [
            'name' => 'test_submit_method',
        ]);
        $controller = new TypeController();

        $response = $controller->submit($request);

        $this->assertEquals(302, $response->getStatusCode());
        Type::where('label', 'test_submit_method')->delete();
    }

    /** @test */
    public function is_types_add_page_correctly_displayed()
    {
        $response = $this->get('/backoffice/types/add');

        $response->assertStatus(200);
    }

    /** @test */
    public function is_types_edit_page_correctly_displayed()
    {
        $type = new Type();
        $type->label = "test_display_editpage";
        $type->save();
        $response = $this->get('/backoffice/types/edit/' . $type->id );

        $response->assertStatus(200);
        Type::destroy($type->id);
    }

    /** @test */
    public function is_update_script_working_correctly(){
        $type = new Type();
        $type->label = "test";
        $type->save();
        $id = $type->id;

        $request = TypeEdit::create('/backoffice/types/edit/' . $id . '/update', 'POST', [
            'id' => $id,
            'name' => 'test_updated',
        ]);
        $controller = new TypeController();

        $response = $controller->update($request);

        $this->assertEquals("test_updated", Type::find($id)->label);
        $this->assertEquals(302, $response->getStatusCode());
        Type::destroy($id);
    }

    /** @test */
    public function is_types_home_page_correctly_displayed()
    {
        $response = $this->get('/backoffice/types');

        $response->assertStatus(200);
    }

    /** @test */
    public function is_delete_script_working_correctly()
    {
        $type = new Type();
        $type->label = "test_delete_script";
        $type->save();

        $this->assertEquals(1, Type::where('id',$type->id)->count());

        $request = Request::create('/backoffice/types/delete/' . $type->id, 'GET', [
            'id' => $type->id,
        ]);

        $controller = new TypeController($request);

        $response = $controller->delete($request);
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals(0, Type::where('id',$type->id)->count());
    }
}
