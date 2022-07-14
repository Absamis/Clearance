<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $primaryKey = "msgid";
    protected $keyType = "string";
    public $increment = false;
    protected $fillable = ["user", "message", "session", "level", "msgid"];
}
