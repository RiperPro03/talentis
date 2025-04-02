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
        Schema::create('locates', function (Blueprint $table) {
            $table->foreignId('company_id')
                ->nullable() // Permet à company_id d'accepter NULL
                ->constrained('companies')
                ->onDelete('set null'); // Met à NULL lors de la suppression

            $table->foreignId('address_id')
                ->constrained('addresses')
                ->onDelete('cascade'); // Supprime l'entrée en cas de suppression de l'adresse

            $table->primary(['company_id', 'address_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locates');
    }
};
