<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Highlight extends Model
{
    use HasFactory;

    protected $table = 'highlights';

    protected $fillable = [
        'description',

        'state',
    ];


    public function highlightsfeature()
    {
        return $this->hasMany(Highlightsfeature::class, 'id_highlight');
    }

    public function highlightsgeneraldescription()
    {
        return $this->hasMany(Highlightsgeneraldescription::class, 'id_highlight');
    }
}
