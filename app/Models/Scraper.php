<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scraper extends Model
{
    use HasFactory;

    protected $table = 'scrapes';

    protected $fillable = [
        'id',
        'user_id',
        'certificate_number',
        'data',
        'status'
    ];

}
