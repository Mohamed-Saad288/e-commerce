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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('password');
            $table->boolean('is_active')->default(true);
            $table->foreignId('organization_id')->nullable()->constrained('organizations')->onDelete('set null');
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        Schema::create('user_otps', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');

            $table->string('email')->nullable();
            $table->string('phone')->nullable();

            $table->string('otp_code');

            $table->timestamp('expires_at');

            $table->tinyInteger('type')->default(1)->comment('1: email, 2: phone');

            $table->tinyInteger('purpose')->default(1)->comment(
                '1: verification, 2: password reset, 3: login verification'
            );

            $table->tinyInteger('status')->default(1)->comment('1: pending, 0: used, -1: expired');

            $table->timestamp('used_at')->nullable();

            $table->integer('attempts')->default(0);

            $table->string('ip_address', 45)->nullable();

            $table->timestamps();

            $table->index(['email', 'type', 'purpose', 'status']);
            $table->index(['phone', 'type', 'purpose', 'status']);
            $table->index(['otp_code', 'type', 'purpose', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('user_otps');
    }
};
