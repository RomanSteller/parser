<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    public $timestamps = false;
    protected $guarded = [];
    use HasFactory;
}
