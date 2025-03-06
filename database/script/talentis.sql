<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('logo_path');
            $table->string('description')->nullable();
            $table->string('email')->unique();
            $table->string('phone_number', 10)->nullable()->unique();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->string('skill_name')->unique();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('role_name')->unique();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('promotion_code')->unique();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('profile_picture_path');
            $table->string('name');
            $table->string('first_name');
            $table->date('birthdate');
            $table->string('password');
            $table->string('email', 255)->unique();
            $table->date('email_verified_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('Id_Promotion')->constrained( 'promotions');
            $table->foreignId('Id_Role')->constrained('roles');
        });

        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('title', 50);
            $table->string('description', 50);
            $table->integer('base_salary')->nullable();
            $table->string('offer_duration', 50)->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreignId('Id_Company')->constrained('companies');
        });

        Schema::create('put_in_wishlist', function (Blueprint $table) {
            $table->foreignId('Id_User')->constrained('users');
            $table->foreignId('Id_Offer')->constrained('offers');
            $table->primary(['Id_User', 'Id_Offer']);
        });

        Schema::create('apply', function (Blueprint $table) {
            $table->foreignId('Id_User')->constrained('users');
            $table->foreignId('Id_Offer')->constrained('offers');
            $table->timestamps();
            $table->string('curriculum_vitae_path', 255);
            $table->string('cover_letter_path', 255);
            $table->primary(['Id_User', 'Id_Offer']);
        });

        Schema::create('contain', function (Blueprint $table) {
            $table->foreignId('Id_Offer')->constrained('offers');
            $table->foreignId('Id_Skill')->constrained('skills');
            $table->primary(['Id_Offer', 'Id_Skill']);
        });

        Schema::create('evaluate', function (Blueprint $table) {
            $table->foreignId('Id_User')->constrained('users');
            $table->foreignId('Id_Company')->constrained('companies');
            $table->string('rating', 2);
            $table->primary(['Id_User', 'Id_Company']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evaluate');
        Schema::dropIfExists('contain');
        Schema::dropIfExists('apply');
        Schema::dropIfExists('put_in_wishlist');
        Schema::dropIfExists('offers');
        Schema::dropIfExists('users');
        Schema::dropIfExists('promotions');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('skills');
        Schema::dropIfExists('companies');
    }
};
