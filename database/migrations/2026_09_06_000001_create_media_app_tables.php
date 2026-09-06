<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('operators', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->foreignId('created_by_admin_id')->nullable()->constrained('admins')->nullOnDelete();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('web_identities', function (Blueprint $table) {
            $table->id();
            $table->string('app_name')->default('Media Plan App');
            $table->text('app_description')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('footer_text')->default('© 2026 Media Plan. All rights reserved.');
            $table->string('theme_default')->default('light');
            $table->timestamps();
        });

        Schema::create('upload_locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('operator_id')->constrained('operators')->cascadeOnDelete();
            $table->string('name');
            $table->string('url')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('operator_id')->constrained('operators')->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('target_date')->nullable();
            $table->enum('status', ['draft', 'in_progress', 'completed', 'cancelled'])->default('draft');
            $table->timestamps();
        });

        Schema::create('project_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->foreignId('upload_location_id')->nullable()->constrained('upload_locations')->nullOnDelete();
            $table->string('item_name');
            $table->enum('media_type', ['video', 'image', 'audio', 'article', 'other'])->default('video');
            $table->text('notes')->nullable();
            $table->enum('status', ['pending', 'ready', 'uploaded'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_details');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('upload_locations');
        Schema::dropIfExists('web_identities');
        Schema::dropIfExists('operators');
        Schema::dropIfExists('admins');
    }
};
