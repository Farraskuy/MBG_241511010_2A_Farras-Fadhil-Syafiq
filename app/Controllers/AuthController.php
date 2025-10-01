<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Users;

class AuthController extends BaseController
{
    public function login()
    {
        return view("auth/login", [
            'validation' => session()->getFlashdata('validation')
        ]);
    }

    public function AuthLogin()
    {
        // Ambil data request (support form biasa & AJAX)
        $requestData = $this->request->isAJAX()
            ? json_decode($this->request->getBody(), true)
            : $this->request->getPost();

        $name = $requestData['name'] ?? null;
        $password = $requestData['password'] ?? null;

        // Validasi input
        $validation = $this->validateData(
            $requestData,
            [
                'name' => 'required',
                'password' => 'required',
            ],
            [
                '*.required' => 'Kolom {field} wajib diisi',
            ]
        );

        if (!$validation) {
            if ($this->request->isAJAX()) {
                return response()->setJSON(['validation' => $this->validator->getErrors()]);
            }
            return redirect()->back()->withInput()->with('validation', $this->validator->getErrors());
        }

        // Cari user hanya di tabel `users`
        $usersModel = new Users();
        $user = $usersModel
            ->where('name', $name)
            ->orWhere('email', $name)
            ->first();

        // Cek user & password
        if (!$user || !password_verify($password, $user['password'])) {
            $errorMessage = ['error' => 'name/Email atau password salah'];

            if ($this->request->isAJAX()) {
                return response()->setJSON($errorMessage);
            }

            return redirect()->back()->withInput()->with('error', $errorMessage['error']);
        }

        // Simpan ke session
        session()->set('users', [
            'id'        => $user['id'],
            'name' => $user['name'],
            'email'     => $user['email'],
            'role'      => $user['role'],
            'logged_in' => true
        ]);

        // Response sukses
        if ($this->request->isAJAX()) {
            return response()->setJSON([
                'success' => true,
                'message' => 'Successfully Login',
                'redirect_to' => base_url()
            ]);
        }
        return redirect()->to('/');
    }

    public function Register()
    {
        return view("auth/register", [
            'validation' => session()->getFlashdata('validation')
        ]);
    }

    public function AuthRegister()
    {
        // bisa diisi nanti untuk register
    }

    public function logout()
    {
        session()->remove('users');

        if ($this->request->isAJAX()) {
            return response()->setJSON([
                'success' => true,
                'message' => 'Successfully logout',
                'redirect_to' => base_url('login')
            ]);
        }
        return redirect()->to('login');
    }
}
