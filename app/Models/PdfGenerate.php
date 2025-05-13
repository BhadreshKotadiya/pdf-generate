<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PdfGenerate extends Model
{
    use HasFactory;
    protected $fillable = ['original_document','converted_pdf'];
}
