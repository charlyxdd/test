<?php

namespace Tests\Feature;

use App\Role;
use App\User;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class UserTest extends TestCase
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

    public function test_create_user(){
        $data = [
            'name' => 'User Test',
            'role_id' => Role::where('name', 'usuario')->first()->id,
            "email" => "user2@mail.com",
            "password" => "secret",
            "status" => 1,
            'image' => UploadedFile::fake()->image('avatar.jpg')
        ];
        $user = User::where('name', 'Master')->first();

        $response = $this->actingAs($user, 'api')->json('POST', 'api/users', $data);
        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 'success',
            ]);
    }

    public function test_read_users(){
        $user = User::where('name', 'Master')->first();

        $response = $this->actingAs($user, 'api')->json('GET', 'api/users');
        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 'success',
            ]);
    }

    public function test_update_user(){
        $data = [
            'name' => 'User Updated',
            "email" => "user2@mail.com",
            'role_id' => Role::where('name', 'usuario')->first()->id,
            "password" => "secret",
            'image' => UploadedFile::fake()->image('avatar.jpg')
        ];
        $user = User::where('name', 'Master')->first();
        $test_user = User::where('name', '!=','Master')->first();

        $response = $this->actingAs($user, 'api')->json('PUT', 'api/users/'.$test_user->id, $data);
        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 'success',
            ]);


    }

    public function test_delete_user(){
        $user = User::where('name', 'Master')->first();
        $test_user = User::where('name', '!=','Master')->first();

        $response = $this->actingAs($user, 'api')->json('DELETE', 'api/users/'.$test_user->id);
        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 'success',
            ]);
    }
}
