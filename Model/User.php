<?php

namespace Model;
use Support\BaseModel;

class User extends BaseModel
{
    protected $table = 'users';
    protected $primaryKey = 'user_id';
}
?>