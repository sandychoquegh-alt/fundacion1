<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('mensajes', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('solicitud_id');
        $table->unsignedBigInteger('remitente_id');  // quién envía
        $table->unsignedBigInteger('destinatario_id'); // quién recibe
        $table->text('mensaje');
        $table->boolean('leido')->default(false);
        $table->timestamps();

        $table->foreign('solicitud_id')->references('id')->on('solicitudes')->onDelete('cascade');
        $table->foreign('remitente_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('destinatario_id')->references('id')->on('users')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mensajes');
    }
    
    
};
