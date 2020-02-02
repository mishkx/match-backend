<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Constants\ModelColumnLength;
use App\Constants\ModelTable;

class CreateSocialAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(ModelTable::USER_SOCIAL_ACCOUNTS, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')
                ->index()->nullable();
            $table->string('provider')
                ->nullable();
            $table->string('provider_user_id')
                ->index()->nullable();

            $table->softDeletes()
                ->index();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on(ModelTable::USERS);

            $table->unique([
                'provider',
                'provider_user_id',
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
        Schema::dropIfExists(ModelTable::USER_SOCIAL_ACCOUNTS);
    }
}
