<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BahanBaku;
use DateTime;

class BahanBakuController extends BaseController
{
    public function index()
    {
        $model = new BahanBaku();
        return view("bahanbaku/index", [
            'bahanbaku' => $model->findAll()
        ]);
    }

    public function detail($id)
    {
        $model = new BahanBaku();
        $item  = $model->find($id);

        if (!$item) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(
                "Bahan Baku dengan ID $id tidak ditemukan"
            );
        }

        return view('bahanbaku/detail', [
            'bahanbaku' => $item,
        ]);
    }

    public function create()
    {
        return view("bahanbaku/create", [
            'validation' => session()->getFlashdata('validation')
        ]);
    }

    public function store()
    {
        $data = $this->request->getPost();

        $rules = [
            'nama'              => 'required|min_length[3]|max_length[255]|is_unique[bahan_baku.nama]',
            'kategori'          => 'required',
            'jumlah'            => 'required|numeric',
            'satuan'            => 'required',
            'tanggal_masuk'     => 'required|valid_date',
            'tanggal_kadaluarsa' => 'required|valid_date'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('validation', $this->validator->getErrors());
        }

        $model = new BahanBaku();
        $model->insert([
            'nama'               => $data['nama'],
            'kategori'           => $data['kategori'],
            'jumlah'             => $data['jumlah'],
            'satuan'             => $data['satuan'],
            'tanggal_masuk'      => $data['tanggal_masuk'],
            'tanggal_kadaluarsa' => $data['tanggal_kadaluarsa'],
        ]);

        return redirect()->to('/bahan-baku')->with('success', 'Bahan Baku berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $model = new BahanBaku();
        $item  = $model->find($id);

        if (!$item) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(
                "Bahan Baku dengan ID $id tidak ditemukan"
            );
        }

        return view('bahanbaku/edit', [
            'validation' => session()->getFlashdata('validation'),
            'bahanbaku'  => $item,
        ]);
    }

    public function update($id)
    {
        $model = new BahanBaku();
        $item  = $model->find($id);

        if (!$item) {
            return redirect()->back()->with('error', 'Bahan Baku tidak ditemukan');
        }

        $data = $this->request->getPost();

        $rules = [
            'nama'              => "required|min_length[3]|max_length[255]|is_unique[bahan_baku.nama,id,{$id}]",
            'kategori'          => 'required',
            'jumlah'            => 'required|numeric|greater_than[0]',
            'satuan'            => 'required',
            'tanggal_masuk'     => 'required|valid_date',
            'tanggal_kadaluarsa' => 'required|valid_date'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('validation', $this->validator->getErrors());
        }

        $model->update($id, [
            'nama'               => $data['nama'],
            'kategori'           => $data['kategori'],
            'jumlah'             => $data['jumlah'],
            'satuan'             => $data['satuan'],
            'tanggal_masuk'      => $data['tanggal_masuk'],
            'tanggal_kadaluarsa' => $data['tanggal_kadaluarsa'] ?? null,
        ]);

        return redirect()->to('/bahan-baku')->with('success', 'Bahan Baku berhasil diupdate.');
    }

    public function destroy($id)
    {
        $model = new BahanBaku();
        $item  = $model->find($id);

        $today = new DateTime(date("Y-m-d"));
        $exp   = new DateTime($item['tanggal_kadaluarsa']);

        if (!($today >= $exp)) {
            return redirect()->to('/bahan-baku')->with('success', 'Bahan Baku belum kadaluarsa.');
        }

        if (!$item) {
            return redirect()->back()->with('error', 'Bahan Baku tidak ditemukan');
        }

        $model->delete($id);

        return redirect()->to('/bahan-baku')->with('success', 'Bahan Baku berhasil dihapus.');
    }
}
