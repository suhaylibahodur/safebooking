<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Condition extends Model
{
  protected $fillable = [
              'name'
            ];
  protected $primaryKey = 'id';
  protected $table = 'condition';
}
