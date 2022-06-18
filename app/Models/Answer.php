<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'content',
        'response_id',
        'question_id',
    ];


    public function question()
    {
        return $this->belongsTo(Question::class);
    }
    public function response()
    {
        return $this->belongsTo(Response::class);
    }
    public function options()
    {
        return $this->belongsToMany('App\Models\Option', 'answers_options');
    }
}
