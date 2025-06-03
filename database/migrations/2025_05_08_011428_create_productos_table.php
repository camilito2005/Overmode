<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();// ID del producto
            $table->string('nombre'); // Nombre del producto
            $table->text('descripcion'); // Descripción del producto
            $table->decimal('precio', 8, 2);// Precio del producto
            $table->string('marca'); // Marca del producto
            $table->unsignedBigInteger('categoria_id')->constrained('categorias')->onDelete('cascade'); // ID de la categoría a la que pertenece el producto
            $table->string('imagen_url')->nullable(); // URL o ruta de la imagen del producto
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
