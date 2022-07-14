<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $primaryKey = "studentid";
    protected $keyType = "string";
    public $incrementing = false;
    protected $fillable = ["name", "matric", "department", "level", "email", "phone", "password", "studentid", "status", "session"];
}
