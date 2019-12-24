<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Constants\ModelColumnLength;
use App\Constants\ModelTable;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(ModelTable::USER_ACTIVITIES, function (Blueprint $table) {
            $coordinateTotalLength = ModelColumnLength::COORDINATE_INT_PART + ModelColumnLength::COORDINATE_FRACTIONAL_PART;

            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')
                ->index()->nullable();
            $table->integer('ip_address')
                ->nullable();
            $table->float('latitude', $coordinateTotalLength, ModelColumnLength::COORDINATE_FRACTIONAL_PART)
                ->index()->nullable();
            $table->float('longitude', $coordinateTotalLength, ModelColumnLength::COORDINATE_FRACTIONAL_PART)
                ->index()->nullable();
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
        Schema::dropIfExists(ModelTable::USER_ACTIVITIES);
    }
}
