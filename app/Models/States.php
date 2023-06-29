<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class States extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function listStates($name) {

        if (!$name) {
            return DB::table('states')->get();
        }

        $states = DB::table('states')->where('name', 'LIKE', "%{$name}%")->get();
        return $states;

    }

    public function teams() {
        return $this->hasMany(Teams::class);
    }


}
