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
        Schema::create('carritos_item', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carrito_id')->constrained('carritos')->onDelete('cascade'); // ID del carrito
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade'); // ID del producto
            $table->foreignId('talla_id')->constrained('tallas')->onDelete('cascade'); // ID de la talla
            $table->foreignId('color_id')->constrained('colores')->onDelete('cascade'); // ID del color
            $table->integer('cantidad'); // Cantidad del producto en el carrito
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carritos_item');
    }
};
