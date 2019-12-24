<?php

namespace App\Models\Account;

use App\Constants\ModelTable;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int|null $user_id
 * @property string|null $session_id
 * @property string|null $ip_address
 * @property float|null $latitude
 * @property float|null $longitude
 * @property boolean $is_accurate
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @mixin Eloquent
 */
class Activity extends Model
{
    protected $table = ModelTable::USER_MATCHES;
}
