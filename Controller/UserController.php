<?php
require_once __DIR__ . '/../Model/UserModel.php';
require_once __DIR__ . '/../bin/support/Request.php';
require_once __DIR__ . '/../bin/support/View.php';
require_once __DIR__ . '/../bin/support/Validator.php';

class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->validator = new Validator();
    }

    public function index()
    {
        $user = $this->userModel->user();
        // include __DIR__.'/../View/user.php'; <-- bisa menggunakan basic ini
        View::render('user', ['user'=>$user],'layout'); //<-- View::render untuk mengembalikan ke halaman yang dituju misalnya user, dan membawa parameter $user untuk menampilkan data, layout untuk menampilkan navbar jika dibutuhkan
    }

    public function adduser()
    {
        View::render('home',[],'layout');
    }

    public function store(Request $request)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'username' => $request->username,
                'email' => $request->email,
                'password' => $request->password
            ];
            $rules = [
                'username' => 'required|min:3|max:50',
                'email' => 'required|email',
                'password' => 'required|min:6'
            ];

            $errors = $this->validator->validate($data,$rules);

            if(!empty($errors)){
                $user = $this->userModel->user();
                View::render('user', ['errors' => $errors, 'data' => $data, 'user' => $user]);
                return;
            } else {
                $result = $this->userModel->addUser($data['username'], $data['email'], $data['password']);
                // $result = $this->userModel->addUser($username, $email, $password); <-- jika tidak menggunakan validasi gunakan seperti ini
                if ($result) {
                    $user = $this->userModel->user();
                    View::redirectTo('/mvc/user');
                } else {    
                    echo "Gagal menambahkan user";
                }
            }
        }
    }

    public function getUserId($id)
    {
        $user = $this->userModel->getUserById($id);
        View::render('edit',['user'=>$user]);
    }

    public function update(Request $request,$id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id =$request->id;
            $username =$request->username;
            $email =$request->email;
            $password =$request->password;

            if(empty($password)){
                $result = $this->userModel->updateUser($id, $username, $email);
            } else {
                $result = $this->userModel->updateUser($id, $username, $email, $password);
            }

            if ($result) {
                $user = $this->userModel->user();
                View::redirectTo('/mvc/user');
            } else {
                echo "Gagal memperbarui user";
            }
        }
    }

    public function delete($id)
    {
        $result = $this->userModel->deleteUser($id);
        if ($result) {
            $user = $this->userModel->user();
            View::redirectTo('/mvc/user');
        } else {
            echo "Gagal menambahkan user";
        }
    }
}
?>