<?php

namespace App\Models\Chat;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int|null $thread_id
 * @property int|null $user_id
 * @property Carbon|null $visited_at
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @mixin Eloquent|SoftDeletes
 */
class Participant extends Model
{
    use SoftDeletes;
}
