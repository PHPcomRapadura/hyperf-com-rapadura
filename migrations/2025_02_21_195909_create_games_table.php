<?php

declare(strict_types=1);

use Hyperf\Database\Migrations\Migration;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Schema\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->bigIncrements('_id');
            $table->string('id');
            $table->string('name');
            $table->string('slug');
            $table->json('data');
            $table->datetimes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
