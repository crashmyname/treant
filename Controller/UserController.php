<?php
require_once __DIR__ . '/../Model/UserModel.php';
require_once __DIR__ . '/../bin/support/Request.php';
require_once __DIR__ . '/../bin/support/View.php';

class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $user = $this->userModel->user();
        include __DIR__.'/../View/user.php';
    }

    public function store(Request $request)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $request->username;
            $email = $request->email;
            $password = $request->password;

            $result = $this->userModel->addUser($username, $email, $password);

            if ($result) {
                $user = $this->userModel->user();
                View::redirectTo('/mvc/user');
            } else {
                // Tampilkan pesan gagal
                echo "Gagal menambahkan user";
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

            if(!$password){
                $result = $this->userModel->updateUser($id, $username, $email);
            } else {
                $result = $this->userModel->updateUser($id, $username, $email, $password);
            }

            if ($result) {
                $user = $this->userModel->user();
                View::redirectTo('/mvc/user');
            } else {
                // Tampilkan pesan gagal
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
            // Tampilkan pesan gagal
            echo "Gagal menambahkan user";
        }
    }
}
?>