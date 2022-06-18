<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{

    protected $fillable = [
        'title',
        'user_id',
    ];

    use HasFactory;
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function responses()
    {
        return $this->hasMany(Response::class);
    }
}
