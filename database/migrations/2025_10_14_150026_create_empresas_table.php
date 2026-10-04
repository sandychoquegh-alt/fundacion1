<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 150);
            $table->string('nit', 50)->nullable()->unique();
            $table->string('representante', 100);
            $table->string('email', 100)->unique();
            $table->string('telefono', 30)->nullable();
            $table->string('direccion')->nullable();
            $table->string('rubro')->nullable();
            $table->string('ciudad')->nullable();
            $table->enum('tipo_empresa', ['micro','pequeña','mediana','grande'])->default('micro');
            $table->date('fecha_registro')->nullable()->default(DB::raw('CURRENT_DATE'));
            
            $table->enum('estado', ['pendiente','en_revision','aprobada','rechazada','inactivo'])->default('pendiente');
            $table->timestamps();
            $table->softDeletes(); // eliminación lógica: deleted_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};

