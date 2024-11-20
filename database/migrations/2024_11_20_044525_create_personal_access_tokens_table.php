<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalAccessTokensTable extends Migration
{
    public function up()
    {
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tokenable_id');
            $table->string('tokenable_type');
            $table->string('name');
            $table->text('token');
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
            $table->text('abilities')->nullable();

            $table->index(['tokenable_id', 'tokenable_type']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('personal_access_tokens');
    }
}
