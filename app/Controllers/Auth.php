<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        // Jika sudah login, langsung ke dashboard
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/login');
    }

    public function attemptLogin()
    {
        $session = session();

        $username = trim($this->request->getPost('username'));
        $password = $this->request->getPost('password');

        // Validasi input
        if ($username === '' || $password === '') {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Username dan password wajib diisi.');
        }

        $userModel = new UserModel();

        $user = $userModel
            ->where('username', $username)
            ->first();

        // User tidak ditemukan
        if (!$user) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Username atau password salah.');
        }

        // Cek password
        if (!password_verify($password, $user['password'])) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Username atau password salah.');
        }

        // Buat session
        $session->set([
            'user_id'   => $user['id'],
            'name'      => $user['name'],
            'username'  => $user['username'],
            'role'      => $user['role'],
            'logged_in' => true
        ]);

        // Regenerate session ID untuk keamanan
        $session->regenerate();

        return redirect()->to('/dashboard');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/login')
            ->with('success', 'Berhasil logout.');
    }
}