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
        Schema::table('users', function (Blueprint $table) {
            $table->string('last_name')->after('id')->nullable();
            $table->string('first_name')->after('id')->nullable();
            $table->unsignedBigInteger('role_id')->after('email')->index();
            $table->string('avatar')->nullable();
            $table->string('status')->after('email_verified_at')->nullable();
            $table->dateTime('last_login')->before('created_at')->nullable();
            $table->softDeletes()->after('updated_at');

            $table->dropColumn('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('last_name');
            $table->dropColumn('first_name');
            $table->dropColumn('role_id');
            $table->dropColumn('avatar');
            $table->dropColumn('status');
            $table->dropColumn('last_login');
            $table->dropColumn('deleted_at');

            $table->string('name')->after('id');
        });
    }
};