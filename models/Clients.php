<?php

namespace models;


class Clients extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['name', 'phone', 'email'];
    public $timestamps = false;

    public function orders()
    {
        return $this->hasMany(Orders::class, 'USER_ID');
    }
}