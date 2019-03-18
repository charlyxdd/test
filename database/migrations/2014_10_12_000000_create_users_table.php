<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('status');
            $table->timestamps();
        });
        $roles = ['usuario', 'administrador', 'vendedor'];
        foreach($roles as $role){
            $r = new \App\Role();
            $r->name=$role;
            $r->status = 1;
            $r->save();
        }

        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email');
            $table->string('password');
            $table->integer('status');
            $table->unsignedBigInteger('role_id');
            $table->foreign('role_id')->references('id')->on('roles');
            $table->rememberToken();
            $table->timestamps();
        });

        $u = new App\User();
        $u->name="Master";
        $u->email="Master";
        $u->password=bcrypt('secret');
        $u->status=1;
        $u->role_id=App\Role::where('name', 'administrador')->first()->id;
        $u->save();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
