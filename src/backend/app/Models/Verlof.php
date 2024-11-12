<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verlof extends Model
{
    use HasFactory;

    // Specificeer de tabelnaam als deze anders is dan de standaard
    protected $table = 'verlof';

    // Geef de primaire sleutel op als deze een andere naam heeft dan 'id'
    protected $primaryKey = 'VerlofID';

    // Geef aan of de primaire sleutel geen auto-increment integer is
    public $incrementing = true;

    // Geef het type van de primaire sleutel aan als het geen integer is
    protected $keyType = 'int';

    // Geef de velden op die ingevuld mogen worden
    protected $fillable = [
        'BeginTijd',
        'BeginDatum',
        'EindTijd',
        'EindDatum',
        'Reden'
    ];
}
