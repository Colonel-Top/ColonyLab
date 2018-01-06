<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ACU extends Pivot
{
    protected $table = 'courses_user';
}