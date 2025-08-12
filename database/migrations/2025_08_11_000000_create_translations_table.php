<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key',191);
            $table->string('locale',10);
            $table->text('value');
            $table->json('tags')->nullable();
            $table->string('context')->nullable();
            $table->timestamps();
            $table->unique(['key','locale']);
        });

        try { DB::statement('ALTER TABLE translations ADD INDEX idx_locale_key (locale(10), `key`(191))'); } catch (\Throwable $e) {}
        try {
            DB::statement("ALTER TABLE translations ADD COLUMN tag0 VARCHAR(191) GENERATED ALWAYS AS (JSON_UNQUOTE(JSON_EXTRACT(`tags`, '$[0]'))) VIRTUAL");
            DB::statement('CREATE INDEX idx_tag0 ON translations (tag0(191))');
        } catch (\Throwable $e) {}
    }

    public function down(): void
    {
        Schema::dropIfExists('translations');
    }
};
