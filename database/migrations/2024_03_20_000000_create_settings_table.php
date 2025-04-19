<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('group')->index(); // 'smtp' or 'recaptcha'
            $table->string('key');
            $table->text('value')->nullable();
            $table->timestamps();

            $table->unique(['group', 'key']);
        });

        // Insert default SMTP settings
        DB::table('settings')->insert([
            [
                'group' => 'smtp',
                'key' => 'host',
                'value' => config('mail.mailers.smtp.host'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'smtp',
                'key' => 'port',
                'value' => config('mail.mailers.smtp.port'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'smtp',
                'key' => 'username',
                'value' => config('mail.mailers.smtp.username'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'smtp',
                'key' => 'encryption',
                'value' => config('mail.mailers.smtp.encryption'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'smtp',
                'key' => 'password',
                'value' => config('mail.mailers.smtp.password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'smtp',
                'key' => 'from_address',
                'value' => config('mail.from.address'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'smtp',
                'key' => 'from_name',
                'value' => config('mail.from.name'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Insert default reCAPTCHA settings
        DB::table('settings')->insert([
            [
                'group' => 'recaptcha',
                'key' => 'site_key',
                'value' => config('services.recaptcha.site_key'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'recaptcha',
                'key' => 'secret_key',
                'value' => config('services.recaptcha.secret_key'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'recaptcha',
                'key' => 'is_enabled',
                'value' => config('services.recaptcha.enabled', false),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
}; 