<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Employees extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'age', 'genre', 'image', 'team_id', 'position_id'];

    public function listEmployees($name) {

        if (!$name) {
            return DB::table('employees')->get();
        }

        $employees = DB::table('employees')->where('name', 'LIKE', "%{$name}%")->get();
        return $employees;

    }


}
