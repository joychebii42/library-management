<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
   
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->timestamp('loaned_at');
            $table->date('due_date');
            $table->timestamp('returned_at')->nullable();
            $table->decimal('penalty_amount', 8, 2)->default(0.00);
            $table->string('penalty_status')->default('unpaid');
            $table->timestamps();
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('loans');
    }
}
