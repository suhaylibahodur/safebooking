<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
  protected $fillable = [
              'name'
            ];
  protected $primaryKey = 'id';
  protected $table = 'room_type';
}
