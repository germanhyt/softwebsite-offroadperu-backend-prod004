<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Highlightsfeature extends Model
{
    use HasFactory;

    protected $table = 'highlightsfeatures';

    protected $fillable = [
        'id_highlight',
        'id_feature',
        'state',
    ];

    public function highlight()
    {
        return $this->belongsTo(Highlight::class, 'id_highlight');
    }

    public function feature()
    {
        return $this->belongsTo(Feature::class, 'id_feature');
    }
}
