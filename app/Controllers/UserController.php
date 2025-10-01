<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Users;

class UserController extends BaseController
{
    public function index()
    {
        $userModel = new Users();

        if ($this->request->isAJAX()) {
            $search = $this->request->getGet("keyword");

            if ($search && $search != '') {
                $users = $userModel
                    ->like('username', $search)
                    ->orLike('email', $search)
                    ->orLike('full_name', $search)
                    ->findAll();
            } else {
                $users = $userModel->findAll();
            }

            return $this->response->setJSON([
                'data' => $users
            ]);
        }

        return view("users/index", ['users' => $userModel->findAll()]);
    }

    public function detail($id)
    {
        $userModel = new Users();
        $user      = $userModel->find($id);

        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("User dengan ID $id tidak ditemukan");
        }

        return view('users/detail', [
            'user' => $user,
        ]);
    }

    public function create()
    {
        return view("users/create", [
            'validation' => session()->getFlashdata('validation')
        ]);
    }

    public function store()
    {
        $data = $this->request->getPost();

        $rules = [
            'full_name' => 'required|min_length[3]|max_length[255]',
            'username'  => 'required|is_unique[users.username]',
            'email'     => 'required|valid_email|is_unique[users.email]',
            'password'  => 'required|min_length[8]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator->getErrors());
        }

        $userModel = new Users();
        $userModel->insert([
            'full_name' => $data['full_name'],
            'username'  => $data['username'],
            'email'     => $data['email'],
            'password'  => password_hash($data['password'], PASSWORD_DEFAULT),
            'role'      => $data['role'] ?? 'student',
        ]);

        return redirect()->to('/users')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $userModel = new Users();
        $user      = $userModel->find($id);

        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("User dengan ID $id tidak ditemukan");
        }

        return view('users/edit', [
            'validation' => session()->getFlashdata('validation'),
            'user'       => $user,
        ]);
    }

    public function update($id)
    {
        $userModel = new Users();
        $user      = $userModel->find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan');
        }

        $data = $this->request->getPost();

        $rules = [
            'full_name' => 'required|min_length[3]|max_length[255]',
            'username'  => "required|is_unique[users.username,id,{$id}]",
            'email'     => "required|valid_email|is_unique[users.email,id,{$id}]",
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator->getErrors());
        }

        $userModel->update($id, [
            'full_name' => $data['full_name'],
            'username'  => $data['username'],
            'email'     => $data['email'],
            'role'      => $data['role'] ?? $user['role'],
        ]);

        return redirect()->to('/users')->with('success', 'User berhasil diupdate.');
    }

    public function editPassword($id)
    {
        $userModel = new Users();
        $user      = $userModel->find($id);

        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("User dengan ID $id tidak ditemukan");
        }

        return view('users/update-password', [
            'validation' => session()->getFlashdata('validation'),
            'user'       => $user,
        ]);
    }

    public function updatePassword($id)
    {
        $userModel = new Users();
        $user      = $userModel->find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan');
        }

        $data = $this->request->getPost();

        $rules = [
            'password'        => 'required|min_length[8]',
            'repeat_password' => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator->getErrors());
        }

        $userModel->update($id, [
            'password' => password_hash($data['password'], PASSWORD_DEFAULT)
        ]);

        return redirect()->to('/users')->with('success', 'Password user berhasil diupdate.');
    }

    public function destroy($id)
    {
        $userModel = new Users();
        $user      = $userModel->find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan');
        }

        $userModel->delete($id);

        return redirect()->to('/users')->with('success', 'User berhasil dihapus.');
    }
}
