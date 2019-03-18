<?php

namespace Tests\Feature;

use App\Role;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_create_role(){
        $data = [
            'name' => 'Role Test',
        ];
        $user = User::where('name', 'Master')->first();

        $response = $this->actingAs($user, 'api')->json('POST', 'api/roles', $data);
        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 'success',
            ]);
    }

    public function test_read_roles(){
        $user = User::where('name', 'Master')->first();

        $response = $this->actingAs($user, 'api')->json('GET', 'api/roles');
        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 'success',
            ]);
    }

    public function test_update_role(){
        $data = [
            'name' => 'Role Updated',
        ];
        $user = User::where('name', 'Master')->first();
        $test_role = Role::whereNotIn('name',['usuario', 'administrador', 'vendedor'])->first();
        $response = $this->actingAs($user, 'api')->json('PUT', 'api/roles/'.$test_role->id, $data);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 'success',
            ]);


    }

    public function test_delete_role(){
        $user = User::where('name', 'Master')->first();
        $test_role = Role::whereNotIn('name',['usuario', 'administrador', 'vendedor'])->first();
        $response = $this->actingAs($user, 'api')->json('DELETE', 'api/roles/'.$test_role->id);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 'success',
            ]);
    }
}
