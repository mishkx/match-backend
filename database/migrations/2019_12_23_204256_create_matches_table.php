<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Constants\ModelTable;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(ModelTable::USER_MATCHES, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('subject_id')
                ->index()->nullable();
            $table->unsignedBigInteger('object_id')
                ->index()->nullable();
            $table->boolean('is_liked')
                ->index()->default(false);
            $table->boolean('is_visited')
                ->default(false);
            $table->timestamp('chosen_at')
                ->index()->nullable();
            $table->timestamp('visited_at')
                ->nullable();

            $table->softDeletes()
                ->index();
            $table->timestamps();

            $table->index([
                'subject_id',
                'object_id',
                'is_liked',
            ]);

            $table->foreign('subject_id')
                ->references('id')->on(ModelTable::USERS);
            $table->foreign('object_id')
                ->references('id')->on(ModelTable::USERS);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(ModelTable::USER_MATCHES);
    }
}
