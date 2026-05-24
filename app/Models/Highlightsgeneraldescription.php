<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Highlightsgeneraldescription extends Model
{
    use HasFactory;

    protected $table = 'highlightsgeneraldescriptions';

    protected $fillable = [
        'description',
        'state',
    ];



    public function generaldescription()
    {
        return $this->belongsTo(Generaldescription::class, 'id_generaldescription');
    }

    public function highlight()
    {
        return $this->belongsTo(Highlight::class, 'id_highlight');
    }
}
