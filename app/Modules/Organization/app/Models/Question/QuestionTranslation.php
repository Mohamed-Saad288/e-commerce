<?php

namespace App\Modules\Organization\app\Models\Question;

use Illuminate\Database\Eloquent\Model;

class QuestionTranslation extends Model
{
    protected $table = 'question_translations';

    protected $guarded = [];

    public $timestamps = false;
}
