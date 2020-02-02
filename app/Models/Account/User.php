<?php

namespace App\Models\Account;

use App\Constants\AppConstants;
use App\Constants\ModelTable;
use App\Models\Chat\Message;
use App\Models\Chat\Participant;
use App\Models\Chat\Thread;
use App\Traits\FillableTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

/**
 * @method static Builder|self withObjectMatchForSubject($subjectId)
 * @method static Builder|self withSubjectMatchForObject($objectId)
 * @method static Builder|self withStateDistance(self $user)
 * @method static Builder|self whereAgeBetween($ageFrom, $ageTo)
 * @method static Builder|self whereGender($gender)
 * @method static Builder|self whereHasMatches($userId)
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property boolean $password_is_set
 * @property string|null $gender
 * @property Carbon|null $born_on
 * @property string|null $description
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Match[] $objectMatches
 * @property-read Collection|Match[] $subjectMatches
 * @property-read Match $objectMatch
 * @property-read Match $subjectMatch
 * @property-read Preference $preference
 * @property-read State $state
 * @property-read Collection|Message[] $messages
 * @property-read Collection|Participant[] $participants
 * @property-read Collection|Thread[] $threads
 * @mixin Eloquent
 */
class User extends Authenticatable
{
    use Notifiable, SoftDeletes, FillableTrait;

    protected $table = ModelTable::USERS;

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password_is_set' => 'boolean',
        'born_on' => 'datetime:' . AppConstants::DATE_FORMAT,
    ];

    public function __construct(array $attributes = [])
    {
        $this->setFillable();
        parent::__construct($attributes);
    }

    public function objectMatches(): HasMany
    {
        return $this->hasMany(Match::class, 'object_id');
    }

    public function subjectMatches(): HasMany
    {
        return $this->hasMany(Match::class, 'subject_id');
    }

    public function objectMatch(): HasOne
    {
        return $this->hasOne(Match::class, 'object_id');
    }

    public function subjectMatch(): HasOne
    {
        return $this->hasOne(Match::class, 'subject_id');
    }

    public function preference(): HasOne
    {
        return $this->hasOne(Preference::class);
    }

    public function state(): HasOne
    {
        return $this->hasOne(State::class);
    }

    public function messages(): BelongsToMany
    {
        return $this->belongsToMany(
            Message::class,
            Participant::class,
            'user_id',
            'id',
            'id',
            'participant_id',
            );
    }

    public function participants(): HasMany
    {
        return $this->hasMany(Participant::class);
    }

    public function threads(): BelongsToMany
    {
        return $this->belongsToMany(Thread::class, Participant::class);
    }

    /**
     * @param self $query
     * @param int $ageFrom
     * @param int $ageTo
     * @return mixed
     */
    public function scopeWhereAgeBetween($query, $ageFrom, $ageTo)
    {
        return $query->whereRaw("TIMESTAMPDIFF(YEAR, born_on, CURDATE()) BETWEEN ? AND ?", [
            $ageFrom,
            $ageTo,
        ]);
    }

    /**
     * @param self $query
     * @param string $gender
     * @return mixed
     */
    public function scopeWhereGender($query, $gender)
    {
        return $query->where('gender', $gender);
    }

    /**
     * @param self $query
     * @param $userId
     * @return mixed
     */
    public function scopeWhereHasMatches($query, $userId)
    {
        return $query
            ->whereHas('subjectMatches', function ($query) use ($userId) {
                /** @var Match $query */
                $query
                    ->whereIsLiked()
                    ->whereObjectId($userId);
            })
            ->whereHas('objectMatches', function ($query) use ($userId) {
                /** @var Match $query */
                $query
                    ->whereIsLiked()
                    ->whereSubjectId($userId);
            });
    }

    /**
     * @param self $query
     * @param $subjectId
     * @return mixed
     */
    public function scopeWithObjectMatchForSubject($query, $subjectId)
    {
        return $query->with([
            'objectMatch' => function ($query) use ($subjectId) {
                /** @var Match $query */
                $query->whereSubjectId($subjectId);
            }
        ]);
    }

    /**
     * @param self $query
     * @param $objectId
     * @return mixed
     */
    public function scopeWithSubjectMatchForObject($query, $objectId)
    {
        return $query->with([
            'subjectMatch' => function ($query) use ($objectId) {
                /** @var Match $query */
                $query->whereObjectId($objectId);
            }
        ]);
    }

    /**
     * @param self $query
     * @param self $user
     * @return mixed
     */
    public function scopeWithStateDistance($query, self $user)
    {
        return $query->with([
            'state' => function ($query) use ($user) {
                /** @var State $query */
                $query->distanceSphereValue('location', $user->state->location);
            }
        ]);
    }
}
