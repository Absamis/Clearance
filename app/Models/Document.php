<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    protected $primaryKey = "documents";
    protected $keyType = "string";
    public $incrementing = false;
    protected $fillable = ["session", "doc_type", "docname", "docid", "user", "level", "status"];
}
