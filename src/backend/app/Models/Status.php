<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $table = 'status';
    protected $primaryKey = 'StatusID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'Naam',        // Nieuwe kolom toegevoegd
        'Omschrijving',
    ];

    /**
     * Relatie met Verlof model
     */
    public function verlof()
    {
        return $this->hasMany(Verlof::class, 'StatusID', 'StatusID');
    }
}
