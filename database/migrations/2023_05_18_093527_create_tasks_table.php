<?php

use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->longText('description');
            $table->enum('level', ['low', 'medium', 'high'])->default('medium');
            $table->dateTime('begin_at')->nullable();
            $table->dateTime('beginned_at')->nullable();
            $table->dateTime('finish_at')->nullable();
            $table->dateTime('finished_at')->nullable();
            $table->boolean('notifiable')->default(true);

            $table->foreignIdFor(User::class)->nullable();
            $table->foreignIdFor(Group::class)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
