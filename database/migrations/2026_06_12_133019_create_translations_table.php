<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('model_translations', function (Blueprint $table) {
            $table->id();

            $table->morphs('model'); // model_id + model_type

            $table->string('locale');
            $table->string('name');
            $table->string('description')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('model_translations');
    }
};
