<?php
namespace Support;
use App\Models\User;
use Support\Session;

class Auth{
    public static function attempt($credentials)
    {
        $user = User::query()
            ->where(function ($query) use ($credentials) {
                $query->where('username', '=', $credentials['identifier'])
                      ->orWhere('email', '=', $credentials['identifier']);
            })
            ->first();
        if($user && password_verify($credentials['password'],$user['password'])){
            Session::set('user', $user->toArray());
            return true;
        }
        return false;
    }
}
?>