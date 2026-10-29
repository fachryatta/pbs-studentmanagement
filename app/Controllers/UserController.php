<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // ==========================================
    // DATA USER
    // ==========================================

    public function index()
    {
        $users = $this->userModel
            ->select('id, name, username, role, created_at, updated_at')
            ->orderBy('name', 'ASC')
            ->findAll();

        $data = [
            'title' => 'Kelola User',
            'users' => $users
        ];

        return view('users/index', $data);
    }


    // ==========================================
    // FORM TAMBAH USER
    // ==========================================

    public function create()
    {
        $data = [
            'title' => 'Tambah User'
        ];

        return view('users/create', $data);
    }


    // ==========================================
    // SIMPAN USER
    // ==========================================

    public function store()
    {
        $rules = [
            'name' => 'required|max_length[100]',
            'username' => 'required|max_length[50]|is_unique[users.username]',
            'password' => 'required|min_length[6]',
            'role' => 'required|in_list[admin,guru]'
        ];

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name' => trim($this->request->getPost('name')),
            'username' => trim($this->request->getPost('username')),
            'password' => password_hash(
                $this->request->getPost('password'),
                PASSWORD_DEFAULT
            ),
            'role' => $this->request->getPost('role')
        ];

        $this->userModel->insert($data);

        return redirect()
            ->to('/users')
            ->with('success', 'User berhasil ditambahkan.');
    }
    


    // ==========================================
    // FORM EDIT USER
    // ==========================================

    public function edit($id)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            return redirect()
                ->to('/users')
                ->with('error', 'User tidak ditemukan.');
        }

        $data = [
            'title' => 'Edit User',
            'user' => $user
        ];

        return view('users/edit', $data);
    }


    // ==========================================
    // UPDATE USER
    // ==========================================

    public function update($id)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            return redirect()
                ->to('/users')
                ->with('error', 'User tidak ditemukan.');
        }

        $password = $this->request->getPost('password');

        $rules = [
            'name' => 'required|max_length[100]',
            'username' => "required|max_length[50]|is_unique[users.username,id,$id]",
            'role' => 'required|in_list[admin,guru]'
        ];

        // Password hanya divalidasi kalau diisi
        if (!empty($password)) {
            $rules['password'] = 'min_length[6]';
        }

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name' => trim($this->request->getPost('name')),
            'username' => trim($this->request->getPost('username')),
            'role' => $this->request->getPost('role')
        ];

        // Kalau password diisi, baru ubah password
        if (!empty($password)) {
            $data['password'] = password_hash(
                $password,
                PASSWORD_DEFAULT
            );
        }

        $this->userModel->update($id, $data);

        return redirect()
            ->to('/users')
            ->with('success', 'Data user berhasil diperbarui.');
    }


    // ==========================================
    // HAPUS USER
    // ==========================================

    public function delete($id)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            return redirect()
                ->to('/users')
                ->with('error', 'User tidak ditemukan.');
        }

        // Jangan izinkan admin menghapus dirinya sendiri
        if ((int) $user['id'] === (int) session()->get('user_id')) {
            return redirect()
                ->to('/users')
                ->with('error', 'Anda tidak dapat menghapus akun yang sedang digunakan.');
        }

        $this->userModel->delete($id);

        return redirect()
            ->to('/users')
            ->with('success', 'User berhasil dihapus.');
    }
}