<?php

namespace App\Models\Chat;

use App\Constants\ModelTable;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property Carbon|null $refreshed_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @mixin Eloquent
 */
class Thread extends Model
{
    protected $table = ModelTable::CHAT_THREADS;
}
