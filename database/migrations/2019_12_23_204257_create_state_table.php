<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Constants\ModelColumnLength;
use App\Constants\ModelTable;

class CreateStateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(ModelTable::USER_STATES, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')
                ->index()->nullable();
            $table->string('session_id')
                ->index()->nullable();
            $table->string('ip_address', ModelColumnLength::SESSION_IP_ADDRESS)
                ->nullable();
            $table->point('location')
                ->nullable();
            $table->boolean('is_accurate')
                ->index()->default(false);

            $table->timestamps();

            $table->foreign('user_id')
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
        Schema::dropIfExists(ModelTable::USER_STATES);
    }
}
