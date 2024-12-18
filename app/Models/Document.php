<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    protected $table = 'documents';

    protected $fillable = ['client', 'project_name', 'discipline', 'document_category', 'document_drawing', 'document_title', 'revision', 'status', 'revision_date', 'pdf', 'native'];
}
