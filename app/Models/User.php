<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use \Illuminate\Database\Eloquent\Relations\HasOne;
use \Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'restricted',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $with = ['profile'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the role that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the verification associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function verification(): HasOne
    {
        return $this->hasOne(UserVerification::class);
    }

    /**
     * Get the user's profile image.
     */
    public function profile(): MorphOne
    {
        return $this->morphOne(File::class, 'fileable');
    }

    /**
     * Get all of the posts for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get all of the comments for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get all of the messagesSent for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messagesSent(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    /**
     * Get all of the messagesSent for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messagesReceived(): HasMany
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    /**
     * Get all of the teacherEvaluations for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function teacherEvaluations(): HasMany
    {
        return $this->hasMany(EvaluationTaken::class, 'teacher_id');
    }

    /**
     * Get all of the studentEvaluations for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function studentEvaluations(): HasMany
    {
        return $this->hasMany(EvaluationTaken::class, 'student_id');
    }

    /**
     * Get all of the studentVote for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function studentVotes(): HasMany
    {
        return $this->hasMany(PollVote::class, 'user_id');
    }
}
