<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
  protected $guarded = [];

  public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
