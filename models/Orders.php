<?php

namespace models;


class Orders extends \Illuminate\Database\Eloquent\Model
{
    public $timestamps = false;
    protected $fillable = ['client_id', 'address', 'comment'];
    
    public function client()
    {
        return $this->hasOne(Clients::class, 'ID', 'USER_ID');
    }
}