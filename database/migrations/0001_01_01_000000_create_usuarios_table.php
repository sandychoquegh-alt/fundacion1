<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration
{
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',50)->unique();
            $table->timestamps();
        });

        // seed roles later via seeder

        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',150);
            $table->string('email',150)->unique();
            $table->string('password');
            $table->foreignId('rol_id')->constrained('roles')->onDelete('cascade');
            $table->boolean('activo')->default(true);
            $table->timestamp('ultimo_login')->nullable();
            $table->rememberToken(); // crea remember_token
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('usuarios');
        Schema::dropIfExists('roles');
    }
}
