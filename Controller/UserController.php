<?php
require_once __DIR__ . '/../Model/UserModel.php';
require_once __DIR__ . '/../bin/support/Request.php';

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
                // Tampilkan pesan sukses atau redirect ke halaman lain
                include __DIR__ . '/../View/berhasil.php';
            } else {
                // Tampilkan pesan gagal
                echo "Gagal menambahkan user";
            }
        }
    }

    public function getUserId($id)
    {
        $user = $this->userModel->getUserById($id);
        include __DIR__.'/../View/edit.php';
    }

    public function update(Request $request)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id =$request->id;
            $username =$request->username;
            $email =$request->email;
            $password =$request->$password;

            if(!$password){
                $result = $this->userModel->updateUser($id, $username, $email);
            } else {
                $result = $this->userModel->updateUser($id, $username, $email, $password);
            }

            if ($result) {
                // Tampilkan pesan sukses atau redirect ke halaman lain
                include __DIR__ . '/../views/berhasil.php';
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
            // Tampilkan pesan sukses atau redirect ke halaman lain
            include __DIR__ . '/../View/berhasil.php';
        } else {
            // Tampilkan pesan gagal
            echo "Gagal menambahkan user";
        }
    }
}
?>