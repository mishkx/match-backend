<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Constants\ModelTable;

class CreateParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(ModelTable::CHAT_PARTICIPANTS, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('thread_id')
                ->index()->nullable();
            $table->unsignedBigInteger('user_id')
                ->index()->nullable();

            $table->timestamp('visited_at')
                ->index()->nullable();
            $table->softDeletes()
                ->index();
            $table->timestamps();

            $table->foreign('thread_id')
                ->references('id')->on(ModelTable::CHAT_THREADS);
            $table->foreign('user_id')
                ->references('id')->on(ModelTable::USERS);

            $table->unique([
                'thread_id',
                'user_id',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists(ModelTable::CHAT_PARTICIPANTS);
        Schema::enableForeignKeyConstraints();
    }
}
