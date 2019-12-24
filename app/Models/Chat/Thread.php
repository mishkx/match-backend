<?php

namespace App\Models\Chat;

use App\Constants\ModelTable;
use App\Models\Account\User;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static Builder|self whereHasNewMessages()
 * @property int $id
 * @property Carbon|null $refreshed_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Message[] $messages
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
}
