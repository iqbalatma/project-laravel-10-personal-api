<?php

use App\Enums\Gender;
use App\Enums\Table;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(Table::PROFILES->value, function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->text("address")->nullable();
            $table->enum("gender", Gender::values())->nullable();
            $table->string("avatar")->nullable();
            $table->date("birth_date")->nullable();
            $table->string("birth_place")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(Table::PROFILES->value);
    }
};
