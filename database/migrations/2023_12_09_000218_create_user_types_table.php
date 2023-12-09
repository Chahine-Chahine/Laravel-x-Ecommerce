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
        Schema::create('user_types', function (Blueprint $table) {
            $table->bigInteger('user_type_id')->primary();
            $table->string('user_type');
        });
        DB::table('user_types')->insert([
            ['user_type_id' => 1, 'user_type' => 'Seller'],
            ['user_type_id' => 2, 'user_type' => 'Customer'],
        ]);
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_types');
    }
};
