<?php

namespace App\Models\Chat;

use App\Base\Model;
use App\Constants\ModelTable;
use App\Models\Account\User;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static Builder|self whereExistsSameThreadUserId($userId, $checkForVisited = false)
 * @method static Builder|self whereUserId($userId)
 * @property int $id
 * @property int|null $thread_id
 * @property int|null $user_id
 * @property Carbon|null $visited_at
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Message[] $messages
 * @property-read Thread $thread
 * @property-read User $user
 * @mixin Eloquent
 */
class Participant extends Model
{
    use SoftDeletes;

    protected $table = ModelTable::CHAT_PARTICIPANTS;

    protected $casts = [
        'visited_at' => 'datetime',
    ];

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function thread(): BelongsTo
    {
        return $this->belongsTo(Thread::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param self $query
     * @param integer $userId
     * @return mixed
     */
    public function scopeWhereUserId($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * @param self $query
     * @param integer $userId
     * @param boolean $checkForVisited
     * @return mixed
     */
    public function scopeWhereExistsSameThreadUserId($query, $userId, $checkForVisited = false)
    {
        return $query->whereExists(function ($query) use ($checkForVisited, $userId) {
            /** @var Builder $query */
            $query->from(ModelTable::CHAT_PARTICIPANTS . ' AS p')
                ->whereColumn('p.thread_id', ModelTable::CHAT_PARTICIPANTS . '.thread_id')
                ->where(function ($query) use ($checkForVisited) {
                    /** @var Builder $query */
                    if ($checkForVisited) {
                        $query->whereNotNull('p.visited_at');
                    }
                })
                ->where('p.user_id', $userId);
        });
    }
}
