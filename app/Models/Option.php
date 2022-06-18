<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    protected $fillable = [
        'value',
        'question_id',
    ];
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function answers()
    {
        return $this->belongsToMany('App\Models\Answer', 'answers_options');
    }
}
