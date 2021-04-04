<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Election extends Model
{
    use HasFactory;

    protected $fillable = ['candidate', 'image', 'title', 'date', 'description', 'election_type_id'];

    public function election_faculty()
    {
        return $this->hasMany(ElectionFaculty::class);
    }
}
