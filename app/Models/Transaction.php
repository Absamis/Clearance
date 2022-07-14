<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $primaryKey = "transID";
    protected $keyType = "string";
    public $incrementing = false;

    protected $fillable = ["user", "session", "transID", "trans_type", "amount", "level"];
}
