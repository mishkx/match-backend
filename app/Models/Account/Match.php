<?php

namespace App\Models\Account;

use App\Constants\ModelTable;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int|null $subject_id
 * @property int|null $object_id
 * @property boolean $is_liked
 * @property Carbon|null $marked_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @mixin Eloquent
 */
class Match extends Model
{
    protected $table = ModelTable::USER_MATCHES;
}
