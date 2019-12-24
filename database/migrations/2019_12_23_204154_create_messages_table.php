<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Constants\ModelTable;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(ModelTable::CHAT_MESSAGES, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('participant_id')
                ->index()->nullable();
            $table->text('content')
                ->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('participant_id')
                ->references('id')->on(ModelTable::CHAT_PARTICIPANTS);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(ModelTable::CHAT_MESSAGES);
    }
}
