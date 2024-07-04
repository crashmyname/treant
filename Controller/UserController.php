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

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $username = $_POST['username'];
            $email = $_POST['email'];

            $result = $this->userModel->updateUser($id, $username, $email);

            if ($result) {
                // Tampilkan pesan sukses atau redirect ke halaman lain
                include __DIR__ . '/../views/user_success.php';
            } else {
                // Tampilkan pesan gagal
                echo "Gagal memperbarui user";
            }
        }
    }
}
?>