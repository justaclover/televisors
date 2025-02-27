<?php

use App\Models\Group;
use App\Models\Playlist;
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
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('comment')->nullable();
            $table->string('location')->nullable();
            $table->foreignIdFor(Playlist::class)->nullable()->constrained()->references('id')->on('playlists');
            $table->foreignIdFor(Group::class)->nullable()->constrained()->references('id')->on('groups');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
