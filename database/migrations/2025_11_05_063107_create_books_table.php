<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
 
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Already exists
            $table->string('author'); // Already exists
            $table->string('publisher');
            $table->year('year_published');
            $table->string('isbn', 13)->unique(); // Already exists, specified length
            $table->string('genre', 100);
            $table->unsignedInteger('quantity')->default(0);
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('books');
    }
}
