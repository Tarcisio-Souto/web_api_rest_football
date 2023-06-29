<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Positions extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function listPositions($name) {

        if (!$name) {
            return DB::table('positions')->get();
        }

        $positions = DB::table('positions')->where('name', 'LIKE', "%{$name}%")->get();
        return $positions;

    }


    public function employees() {
        return $this->hasMany(Employees::class);
    }

}
