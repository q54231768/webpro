<?php


namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table='user';
    protected $primaryKey='id';
    public $timestamps = false;

//    protected $timestamps=false;
}
