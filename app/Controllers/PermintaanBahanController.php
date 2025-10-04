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

    public function detail($id)
    {
        $permintaanModel = new PermintaanBahan();
        $detailModel     = new PermintaanBahanDetail();

        $permintaan = $permintaanModel
            ->select('permintaan.*, user.name as pemohon_nama')
            ->join('user', 'user.id = permintaan.pemohon_id', 'left')
            ->where('permintaan.id', $id)
            ->first();

        if (!$permintaan) {
            return redirect()->to('/permintaan-bahan')->with('error', 'Data tidak ditemukan.');
        }

        $details = $detailModel
            ->select('permintaan_detail.*, bahan_baku.nama, bahan_baku.kategori, bahan_baku.satuan')
            ->join('bahan_baku', 'bahan_baku.id = permintaan_detail.bahan_id', 'left')
            ->where('permintaan_detail.permintaan_id', $id)
            ->findAll();

        $permintaan['details'] = $details;

        return view('permintaanbahan/detail', [
            'permintaan' => $permintaan
        ]);
    }

    public function store()
    {
        $data = $this->request->getPost();

        $rules = [
            'menu_makan'   => 'required|min_length[3]',
            'jumlah_porsi' => 'required|numeric|greater_than[0]',
            'tanggal_masuk' => 'required|valid_date',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('validation', $this->validator->getErrors());
        }

        $permintaanModel = new PermintaanBahan();
        $detailModel     = new PermintaanBahanDetail();
        $bahanModel      = new BahanBaku();

        $db = $permintaanModel->db;
        $db->transStart();

        $permintaanId = $permintaanModel->insert(row: [
            'pemohon_id'    => session()->get('users')['id'],
            'menu_makan'    => $data['menu_makan'],
            'jumlah_porsi'  => $data['jumlah_porsi'],
            'tanggal_masuk' => $data['tanggal_masuk'],
            'status'        => 'menunggu'
        ]);

        $sessionBahan = session('bahan_terpilih') ?? [];

        foreach ($sessionBahan as $bahan) {
            $item = $bahanModel->find($bahan['id']);
            if (!$item || $item['jumlah'] < $bahan['jumlah']) {
                $db->transRollback();
                return redirect()->back()
                    ->with('error', "Stok untuk {$bahan['nama']} tidak mencukupi")
                    ->withInput();
            }

            $detailModel->insert([
                'permintaan_id' => $permintaanId,
                'bahan_id' => $bahan['id'],
                'jumlah_diminta' => $bahan['jumlah'],
            ]);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()
                ->with('error', "Terjadi kesalahan transaksi, data tidak tersimpan.")
                ->withInput();
        }

        session()->remove('bahan_terpilih');

        return redirect()->to('/permintaan-bahan')
            ->with('success', 'Permintaan bahan berhasil dibuat dan stok sudah dikurangi.');
    }

    public function approve($id)
    {
        $permintaanModel = new PermintaanBahan();
        $detailModel     = new PermintaanBahanDetail();
        $bahanModel      = new BahanBaku();

        $permintaan = $permintaanModel->find($id);
        if (!$permintaan) {
            return redirect()->back()->with('error', 'Permintaan tidak ditemukan');
        }
        if ($permintaan['status'] !== 'menunggu') {
            return redirect()->back()->with('error', 'Permintaan sudah diproses');
        }

        $db = $permintaanModel->db;
        $db->transStart();

        $details = $detailModel->where('permintaan_id', $id)->findAll();

        foreach ($details as $d) {
            $bahan = $bahanModel->find($d['bahan_id']);
            if (!$bahan || $bahan['jumlah'] < $d['jumlah_diminta']) {
                $db->transRollback();
                return redirect()->back()->with('error', "Stok untuk {$bahan['nama']} tidak mencukupi");
            }

            $bahanModel->update($d['bahan_id'], [
                'jumlah' => $bahan['jumlah'] - $d['jumlah_diminta']
            ]);
        }

        $permintaanModel->update($id, ['status' => 'disetujui']);
        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal menyetujui permintaan');
        }

        return redirect()->back()->with('success', 'Permintaan berhasil disetujui');
    }

    public function reject($id)
    {
        $model = new PermintaanBahan();
        $item  = $model->find($id);

        $validate = $this->validate([
            'alasan_penolakan' => 'required'
        ]);

        if (!$validate) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Alasan penolakan wajib diisi')
                ->with('validation', $this->validator->getErrors());
        }

        if (!$item) {
            return redirect()->back()->with('error', 'Permintaan tidak ditemukan');
        }

        if ($item['status'] !== 'menunggu') {
            return redirect()->back()->with('error', 'Permintaan sudah diproses');
        }

        $model->update($id, ['status' => 'ditolak', 'alasan_penolakan' => $this->request->getPost('alasan_penolakan')]);
        return redirect()->back()->with('success', 'Permintaan berhasil ditolak');
    }


    public function addBahan($id)
    {
        $bahanModel = new BahanBaku();
        $bahan = $bahanModel->find($id);

        if (!$bahan) {
            return redirect()->back()->with('error', 'Bahan tidak ditemukan');
        }

        $jumlah = (int) $this->request->getPost('jumlah');

        if ($jumlah <= 0) {
            return redirect()->back()->with('error', 'Jumlah harus lebih dari 0');
        }

        if ($bahan['jumlah'] < $jumlah) {
            return redirect()->back()->with('error', "Stok {$bahan['nama']} tidak mencukupi.");
        }

        $sessionBahan = session('bahan_terpilih') ?? [];

        foreach ($sessionBahan as $item) {
            if ($item['id'] == $id) {
                return redirect()->back()->with('error', 'Bahan sudah ada dalam daftar');
            }
        }

        $sessionBahan[$id] = [
            'id'      => $bahan['id'],
            'nama'    => $bahan['nama'],
            'kategori' => $bahan['kategori'],
            'jumlah'  => $jumlah,
            'satuan'  => $bahan['satuan'],
        ];

        session()->set('bahan_terpilih', $sessionBahan);

        return redirect()->back()->with('success', 'Bahan ditambahkan ke daftar.');
    }

    public function removeBahan($id)
    {
        $sessionBahan = session('bahan_terpilih') ?? [];

        if (isset($sessionBahan[$id])) {
            unset($sessionBahan[$id]);
            session()->set('bahan_terpilih', $sessionBahan);
        }

        return redirect()->back()->with('success', 'Bahan dihapus dari daftar.');
    }
    public function destroy($id)
    {
        $permintaanModel = new PermintaanBahan();
        $detailModel     = new PermintaanBahanDetail();

        $permintaan = $permintaanModel->find($id);
        if (!$permintaan) {
            return redirect()->back()->with('error', 'Permintaan tidak ditemukan');
        }
        if ($permintaan['status'] != 'menunggu') {
            return redirect()->back()->with('error', 'Permintaan tidak dapat dihapus jika sudah diproses.');
        }

        $db = $permintaanModel->db;
        $db->transStart();

        $detailModel->where('permintaan_id', $id)->delete();
        $permintaanModel->delete($id);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal menghapus permintaan.');
        }

        return redirect()->back()->with('success', 'Permintaan dihapus dari daftar.');
    }
}
