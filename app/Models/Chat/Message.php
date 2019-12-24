<?php

namespace App\Models\Chat;

use App\Constants\ModelTable;
use App\Models\Account\User;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @package Message
 * @property int $id
 * @property int|null $participant_id
 * @property string|null $content
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Participant $participant
 * @property-read Thread $thread
 * @property-read User $user
 * @mixin Eloquent
 */
class Message extends Model
{
    use SoftDeletes;

    protected $table = ModelTable::CHAT_MESSAGES;

    public function participant(): BelongsTo
    {
        return $this->belongsTo(Participant::class);
    }

    public function thread(): HasOneThrough
    {
        return $this->hasOneThrough(
            Thread::class,
            Participant::class,
            'id',
            'id',
            'participant_id',
            'thread_id'
        );
    }

    public function user(): HasOneThrough
    {
        return $this->hasOneThrough(
            User::class,
            Participant::class,
            'id',
            'id',
            'participant_id',
            'user_id'
        );
    }
}
