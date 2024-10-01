<?php

namespace Model;
use Support\BaseModel;

class User extends BaseModel
{
    // Model logic here
    public $table = 'users';
    protected $primaryKey = 'user_id';
}
