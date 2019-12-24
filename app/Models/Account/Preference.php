<?php

namespace App\Models\Account;

use App\Constants\ModelTable;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int|null $user_id
 * @property int|null $age_from
 * @property int|null $age_to
 * @property int|null $max_distance
 * @property int|string $gender
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @mixin Eloquent
 */
class Preference extends Model
{
    protected $table = ModelTable::USER_PREFERENCES;
}
