<?php

namespace App\Models\Account;

use App\Constants\ModelTable;
use App\Models\Chat\Message;
use App\Models\Chat\Participant;
use App\Models\Chat\Thread;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Eloquent;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property string|null $gender
 * @property Carbon|null $born_on
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Activity[] $activities
 * @property-read Collection|Match[] $objectMatches
 * @property-read Collection|Match[] $subjectMatches
 * @property-read Preference $preference
 * @property-read Collection|Message[] $messages
 * @property-read Collection|Participant[] $participants
 * @property-read Collection|Thread[] $threads
 * @mixin Eloquent
 */
class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $table = ModelTable::USERS;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'born_on' => 'datetime:Y-m-d',
    ];

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }

    public function objectMatches(): HasMany
    {
        return $this->hasMany(Match::class, 'object_id');
    }

    public function subjectMatches(): HasMany
    {
        return $this->hasMany(Match::class, 'subject_id');
    }

    public function preference(): HasOne
    {
        return $this->hasOne(Preference::class);
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
}
