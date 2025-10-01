<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BahanBaku;
use App\Models\PermintaanBahan;
use App\Models\PermintaanBahanDetail;

class PermintaanBahanController extends BaseController
{

    public function index()
    {
        $permintaanModel = new PermintaanBahan();
        $detailModel     = new PermintaanBahanDetail();
        $bahanModel      = new BahanBaku();

        $permintaan = $permintaanModel->findAll();

        foreach ($permintaan as &$p) {
            $details = $detailModel->where('permintaan_id', $p['id'])->findAll();
            foreach ($details as &$d) {
                $bahan = $bahanModel->find($d['bahan_id']);
                $d['nama_bahan'] = $bahan['nama'] ?? '-';
                $d['kategori']   = $bahan['kategori'] ?? '-';
            }
            $p['details'] = $details;
        }


        return view('permintaanbahan/index', [
            'permintaan' => $permintaan
        ]);
    }

    public function create()
    {
        $bahanBaku = new BahanBaku();
        return view("permintaanbahan/create", [
            'validation' => session()->getFlashdata('validation'),
            'bahan_baku' => $bahanBaku->findAll(),
        ]);
    }


    // Simpan form utama + detail dari session
    public function store()
    {
        $data = $this->request->getPost();

        $rules = [
            'menu_makan'  => 'required|min_length[3]',
            'jumlah_porsi'  => 'required|numeric|greater_than[0]',
            'tanggal_masuk' => 'required|valid_date',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('validation', $this->validator->getErrors());
        }

        // simpan permintaan
        $permintaanModel = new PermintaanBahan();
        $permintaanId = $permintaanModel->insert([
            'pemohon_id' => session()->get('users')['id'], 
            'menu_makan'  => $data['menu_makan'],
            'jumlah_porsi'  => $data['jumlah_porsi'],
            'tanggal_masuk' => $data['tanggal_masuk'],
            'status'        => 'menunggu'
        ]);

        // simpan detail bahan dari session
        $sessionBahan = session('bahan_terpilih') ?? [];
        $detailModel = new PermintaanBahanDetail();
        $bahanModel  = new BahanBaku();

        foreach ($sessionBahan as $bahan) {
            // simpan ke detail
            $detailModel->insert([
                'permintaan_id' => $permintaanId,
                'bahan_id'      => $bahan['id'],
                'jumlah'        => $bahan['jumlah'],
                'satuan'        => $bahan['satuan'],
            ]);

            // kurangi stok di tabel bahan_baku
            $item = $bahanModel->find($bahan['id']);
            if ($item) {
                $stokBaru = max(0, $item['jumlah'] - $bahan['jumlah']); 
                $bahanModel->update($bahan['id'], [
                    'jumlah' => $stokBaru
                ]);
            }
        }

        // clear session
        session()->remove('bahan_terpilih');

        return redirect()->to('/permintaan-bahan')->with('success', 'Permintaan bahan berhasil dibuat dan stok sudah dikurangi.');
    }


    public function approve($id)
    {
        $model = new PermintaanBahan();
        $item  = $model->find($id);

        if (!$item) {
            return redirect()->back()->with('error', 'Permintaan tidak ditemukan');
        }

        if ($item['status'] !== 'menunggu') {
            return redirect()->back()->with('error', 'Permintaan sudah diproses');
        }

        $model->update($id, ['status' => 'approved']);
        return redirect()->back()->with('success', 'Permintaan berhasil disetujui');
    }

    public function reject($id)
    {
        $model = new PermintaanBahan();
        $item  = $model->find($id);

        if (!$item) {
            return redirect()->back()->with('error', 'Permintaan tidak ditemukan');
        }

        if ($item['status'] !== 'menunggu') {
            return redirect()->back()->with('error', 'Permintaan sudah diproses');
        }

        $model->update($id, ['status' => 'rejected']);
        return redirect()->back()->with('success', 'Permintaan berhasil ditolak');
    }


    // Tambahkan bahan ke session
    public function addBahan($id)
    {
        $bahanModel = new BahanBaku();
        $bahan = $bahanModel->find($id);

        if (!$bahan) {
            return redirect()->back()->with('error', 'Bahan tidak ditemukan');
        }

        $sessionBahan = session('bahan_terpilih') ?? [];

        // pastikan tidak double
        foreach ($sessionBahan as $item) {
            if ($item['id'] == $id) {
                return redirect()->back()->with('error', 'Bahan sudah ada dalam daftar');
            }
        }

        $sessionBahan[$id] = [
            'id'      => $bahan['id'],
            'nama'    => $bahan['nama'],
            'kategori' => $bahan['kategori'],
            'jumlah'  => $this->request->getPost('jumlah'),
            'satuan'  => $bahan['satuan'],
        ];

        session()->set('bahan_terpilih', $sessionBahan);

        return redirect()->back()->with('success', 'Bahan ditambahkan ke daftar.');
    }

    // Hapus bahan dari session
    public function removeBahan($id)
    {
        session()->remove('bahan_terpilih');

    $sessionBahan = session('bahan_terpilih') ?? [];

        if (isset($sessionBahan[$id])) {
            unset($sessionBahan[$id]);
            session()->set('bahan_terpilih', $sessionBahan);
        }

        return redirect()->back()->with('success', 'Bahan dihapus dari daftar.');
    }
}
