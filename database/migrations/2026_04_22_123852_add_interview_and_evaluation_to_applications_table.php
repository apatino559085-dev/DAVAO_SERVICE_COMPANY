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
        Schema::table('applications', function (Blueprint $table) {
            $table->dateTime('interview_at')->nullable();
            $table->string('interview_location')->nullable();
            $table->integer('rating')->nullable();
            $table->string('id_picture_path')->nullable();
            $table->string('certificates_path')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn(['interview_at', 'interview_location', 'rating', 'id_picture_path', 'certificates_path']);
        });
    }
};
