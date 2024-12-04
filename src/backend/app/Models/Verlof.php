<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verlof extends Model
{
    use HasFactory;

    // Specificeer de tabelnaam als deze anders is dan de standaard
    protected $table = 'verlof';

    // Geef de velden op die ingevuld mogen worden
    protected $fillable = [
        'BeginTijd',
        'BeginDatum',
        'EindTijd',
        'EindDatum',
        'Reden',
        'StatusID'
    ];

}
