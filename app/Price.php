<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;


class Price extends Model
{
    use SoftDeletes, LaravelVueDatatableTrait;
}
