<?php

namespace App\Controller;
use Support\Response;
use Support\Request;
use Support\Validator;
use Support\View;
use Support\CSRFToken;
use App\Model\User;

class UserController
{
    protected $validator;
    public function __construct()
    {
        // $this->userModel = new UserModel();
        $this->validator = new Validator();
    }
    public function index()
    {
        $users = [
            ['id' => 1, 'name' => 'John Doe'],
            ['id' => 2, 'name' => 'Jane Doe'],
        ];

        // Kembalikan response dalam bentuk JSON
        Response::json(['status_code'=>200,'message'=>'Berhasil get api','data'=>$users]);
    }

    public function loginapi()
    {
        $request = new Request();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'email' => $request->email,
                'password' => $request->password
            ];

            $rule = [
                'email' => 'required',
                'password' => 'required'
            ];
            
            $error = $this->validator->validate($data, $rule);
            if ($error) {
                View::render('login', ['errors' => $error]);
            } else {
                $user = User::query()->where('email', '=', $data['email'])->first();
                if ($user) {
                    if (password_verify($data['password'],$user['password'])) {
                        // Generate token
                        $token = bin2hex(random_bytes(32));
                        $_SESSION['token'] = $token;
                        header('Content-Type: application/json');
                        echo json_encode(['token' => $token]);
                    }
                } else {
                    echo json_encode(['error' => 'Email atau password salah!!!!!!']);
                }
            }
        }
    }
}
