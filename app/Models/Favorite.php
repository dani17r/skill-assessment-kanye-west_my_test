<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Favorite extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'dislike',
        'quote',
        'like',
    ];

    protected $casts = [
        'dislike' => 'boolean',
        'like' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
