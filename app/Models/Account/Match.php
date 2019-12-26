<?php

namespace App\Models\Account;

use App\Base\Model;
use App\Constants\ModelTable;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static Builder|self whereDoesntLike()
 * @method static Builder|self whereIsLiked()
 * @method static Builder|self whereRenewalPeriodHasCome()
 * @method static Builder|self whereObjectId($subjectId)
 * @method static Builder|self whereSubjectId($subjectId)
 * @property int $id
 * @property int|null $subject_id
 * @property int|null $object_id
 * @property boolean $is_liked
 * @property Carbon|null $marked_at
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User $object
 * @property-read User $subject
 * @mixin Eloquent
 */
class Match extends Model
{
    use SoftDeletes;

    protected $table = ModelTable::USER_MATCHES;

    protected $casts = [
        'is_liked' => 'boolean',
        'marked_at' => 'datetime',
    ];

    public function object(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param self $query
     * @return mixed
     */
    public function scopeWhereDoesntLike($query)
    {
        return $query->where('is_liked', false);
    }

    /**
     * @param self $query
     * @return mixed
     */
    public function scopeWhereIsLiked($query)
    {
        return $query->where('is_liked', true);
    }

    /**
     * @param self $query
     * @param int $subjectId
     * @return mixed
     */
    public function scopeWhereSubjectId($query, $subjectId)
    {
        return $query->where('subject_id', $subjectId);
    }

    /**
     * @param self $query
     * @param int $objectId
     * @return mixed
     */
    public function scopeWhereObjectId($query, $objectId)
    {
        return $query->where('object_id', $objectId);
    }

    /**
     * @param self $query
     * @return mixed
     */
    public function scopeWhereRenewalPeriodHasCome($query)
    {
        return $query->where(
            'marked_at',
            '<=',
            Carbon::now()->subDays(config('options.match.renewalPeriod'))->toDateTimeString()
        );
    }
}
