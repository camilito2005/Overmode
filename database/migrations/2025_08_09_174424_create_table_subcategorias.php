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
        Schema::create('subcategorias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('categoria_id'); // foreng key de la tabla categorias
            //ahora agrego un campo para la subcategoria de la subcategoria (parent_id)
            $table->unsignedBigInteger('parent_id')->nullable()->after('id'); // permite subcategorias anidadas
            $table->foreign('parent_id')->references('id')->on('subcategorias')->onDelete('cascade');
            //agrego el campo subcategoria
            $table->string('subcategoria');
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subcategorias');
    }
};
