<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Helper\CarBrands;



return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vehicules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger ("category_id");
            $table->foreign("category_id")->references("id")->on("categories")->onDelete("cascade");
            $table->boolean("a/c");
            $table->integer("suitcases");
            $table->integer("doors");
            $table->integer("passengers");
            $table->boolean("automatic");
            $table->enum("brand",CarBrands::$brands);
            $table->string("model");
            $table->enum("fuel_type", ["petrol", "diesel", "electric", "hybrid", "gasoline"]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicules');
    }
};
