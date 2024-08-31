<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scrape extends Model
{
    use HasFactory;

    protected $table = 'scrapes';

    protected $fillable = [
        'user_id',
        'certificate_number',
        'data',
        'status'
    ];

}
