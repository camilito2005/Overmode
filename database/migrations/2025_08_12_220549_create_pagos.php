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
        //
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->nullable()->constrained('pedidos')->onDelete('set null'); // si lo vinculas
            $table->foreignId('carrito_id')->nullable()->constrained('carritos')->onDelete('set null'); // opcional
            $table->foreignId('usuario_id')->nullable()->constrained('usuarios')->onDelete('set null');

            $table->string('gateway')->default('paypal');
            $table->string('order_id')->nullable()->unique();   // id de PayPal (ORDER)
            $table->string('capture_id')->nullable()->index(); // id de captura (si aplica)
            $table->decimal('amount', 12, 2);
            $table->string('currency', 10)->default('USD');
            $table->string('status')->index(); // CREATED, APPROVED, COMPLETED, REFUNDED, FAILED...
            $table->integer('attempts')->default(0); // intentos de captura / reintentos
            $table->string('request_id')->nullable(); // idempotency key (tu UUID)
            $table->json('response')->nullable(); // payload raw del gateway
            $table->json('meta')->nullable(); // cualquier otro dato (buyer, payer, shipping)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('pagos');
    }
};
