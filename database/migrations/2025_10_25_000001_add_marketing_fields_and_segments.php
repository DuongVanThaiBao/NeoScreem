<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Users: gender, dob
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'gender')) {
                    $table->enum('gender', ['male','female','other'])->nullable()->after('role');
                }
                if (!Schema::hasColumn('users', 'dob')) {
                    $table->date('dob')->nullable()->after('gender');
                }
            });
        }

        // Orders: channel, total_amount, user_id (if missing)
        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                if (!Schema::hasColumn('orders', 'channel')) {
                    $table->enum('channel', ['website','app','counter','partner'])->nullable()->after('status');
                }
                if (!Schema::hasColumn('orders', 'total_amount')) {
                    $table->decimal('total_amount', 15, 2)->default(0)->after('channel');
                }
                if (!Schema::hasColumn('orders', 'user_id')) {
                    $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete()->after('id');
                }
            });
        }

        // Movies: genre
        if (Schema::hasTable('movies')) {
            Schema::table('movies', function (Blueprint $table) {
                if (!Schema::hasColumn('movies', 'genre')) {
                    $table->string('genre')->nullable()->after('title');
                }
            });
        }

        // Segments table
        if (!Schema::hasTable('segments')) {
            Schema::create('segments', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->json('filters');
                $table->unsignedInteger('size')->default(0);
                $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('segments')) {
            Schema::dropIfExists('segments');
        }
        if (Schema::hasTable('movies') && Schema::hasColumn('movies', 'genre')) {
            Schema::table('movies', function (Blueprint $table) { $table->dropColumn('genre'); });
        }
        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                if (Schema::hasColumn('orders', 'user_id')) { $table->dropConstrainedForeignId('user_id'); }
                if (Schema::hasColumn('orders', 'total_amount')) { $table->dropColumn('total_amount'); }
                if (Schema::hasColumn('orders', 'channel')) { $table->dropColumn('channel'); }
            });
        }
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (Schema::hasColumn('users', 'dob')) { $table->dropColumn('dob'); }
                if (Schema::hasColumn('users', 'gender')) { $table->dropColumn('gender'); }
            });
        }
    }
};
