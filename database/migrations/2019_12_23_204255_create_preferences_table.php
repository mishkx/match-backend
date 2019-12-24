<?php

use App\Constants\ModelColumnLength;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Constants\ModelTable;

class CreatePreferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(ModelTable::USER_PREFERENCES, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')
                ->index()->nullable();
            $table->smallInteger('age_from')
                ->index()->nullable();
            $table->smallInteger('age_to')
                ->index()->nullable();
            $table->smallInteger('max_distance')
                ->index()->nullable();
            $table->string('gender', ModelColumnLength::USER_GENDER)
                ->index()->nullable();

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
        Schema::dropIfExists(ModelTable::USER_PREFERENCES);
    }
}
