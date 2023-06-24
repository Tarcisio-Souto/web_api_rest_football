<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Teams extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image', 'state_id'];

    public function listTeams($name) {

        if (!$name) {
            return DB::table('teams')->get();
        }

        $teams = DB::table('teams')->where('name', 'LIKE', "%{$name}%")->get();
        return $teams;

    }



}
