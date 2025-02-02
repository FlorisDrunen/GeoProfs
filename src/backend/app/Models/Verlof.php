<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verlof extends Model
{
    use HasFactory;

    protected $table = 'verlof';

    protected $fillable = [
        'user_id',
        'begin_tijd',
        'begin_datum',
        'eind_tijd',
        'eind_datum',
        'reden',
        'status'
    ];
    
    public function user()
{
    return $this->belongsTo(User::class, 'user_id', 'id');
}

}
