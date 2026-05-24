<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use HasFactory;

    protected $table = 'features';

    protected $fillable = [
        'description',

        'state',
    ];

    public function featuresproduct()
    {
        return $this->hasMany(Featuresproduct::class, 'id_feature');
    }

    public function highlightsfeature()
    {
        return $this->hasMany(Highlightsfeature::class, 'id_feature');
    }


}
