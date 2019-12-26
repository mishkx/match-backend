<?php

namespace App\Models\Chat;

use App\Base\Model;
use App\Constants\ModelTable;
use App\Models\Account\User;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

/**
 * @method static Builder|self whereAvailableForUser($userId)
 * @method static Builder|self whereHasNewMessages()
 * @method static Builder|self withLatestMessage()
 * @property int $id
 * @property Carbon|null $refreshed_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Message[] $messages
 * @property-read Message $latestMessage
 * @property-read Collection|Participant[] $participants
 * @property-read Collection|User[] $users
 * @mixin Eloquent
 */
class Thread extends Model
{
    protected $table = ModelTable::CHAT_THREADS;

    protected $casts = [
        'refreshed_at' => 'datetime',
    ];

    public function messages(): BelongsToMany
    {
        return $this->belongsToMany(
            Message::class,
            Participant::class,
            'thread_id',
            'id',
            'id',
            'participant_id'
        );
    }

    public function latestMessage(): HasOneThrough
    {
        return $this
            ->hasOneThrough(
                Message::class,
                Participant::class,
                'thread_id',
                'participant_id',
                'id',
                'id'
            )
            ->latest();
    }

    public function participants(): HasMany
    {
        return $this->hasMany(Participant::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, Participant::class);
    }

    /**
     * @param self $query
     * @return mixed
     */
    public function scopeWhereHasNewMessages($query)
    {
        return $query->whereHas('participants', function ($query) {
            /** @var Participant $query */
            $query->whereNull('visited_at')
                ->orWhereColumn('refreshed_at', '>', 'visited_at');
        });
    }

    /**
     * @param self $query
     * @return mixed
     */
    public function scopeWithLatestMessage($query)
    {
        return $query->with('latestMessage');
    }

    /**
     * @param self $query
     * @param int $userId
     * @return mixed
     */
    public function scopeWhereAvailableForUser($query, $userId)
    {
        return $query
            ->whereHas('users', function ($query) use ($userId) {
                /** @var User $query */
                $query->whereHasMatches($userId);
            })
            ->whereHas('participants.user', function ($query) use ($userId) {
                /** @var User $query */
                $query->where('id', $userId);
            });
    }
}
