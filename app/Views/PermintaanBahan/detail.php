<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
Detail Permintaan Bahan
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="mb-4">
    <h2 class="fw-bold">Detail Permintaan Bahan</h2>
    <p class="text-muted">Informasi detail permintaan bahan</p>
    <a href="<?= base_url('permintaan-bahan') ?>" class="btn btn-secondary">Kembali</a>
</div>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-light fw-semibold">
        Informasi Permintaan
    </div>
    <div class="card-body">
        <h5 class="card-title fw-bold mb-3">
            <?= esc($permintaan['menu_makan']) ?>
        </h5>
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <p class="mb-1"><strong>Pemohon:</strong></p>
                <p class="text-muted"><?= esc($permintaan['pemohon_nama'] ?? '-') ?></p>
            </div>
            <div class="col-md-6">
                <p class="mb-1"><strong>Jumlah Porsi:</strong></p>
                <p class="text-muted"><?= esc($permintaan['jumlah_porsi']) ?></p>
            </div>
            <div class="col-md-6">
                <p class="mb-1"><strong>Tanggal Masak:</strong></p>
                <p class="text-muted"><?= esc($permintaan['tgl_masak']) ?></p>
            </div>
            <div class="col-md-6">
                <p class="mb-1"><strong>Status:</strong></p>
                <span class="badge px-3 py-2
                    <?= $permintaan['status'] == 'disetujui' ? 'bg-success'
                        : ($permintaan['status'] == 'ditolak' ? 'bg-danger'
                            : 'bg-warning text-dark') ?>">
                    <?= ucfirst($permintaan['status']) ?>
                </span>
            </div>
            <?php if ($permintaan['status'] === 'ditolak'): ?>
                <div class="col-12">
                    <p class="mb-1"><strong>Alasan Penolakan:</strong></p>
                    <p class="text-danger fst-italic">
                        <?= esc($permintaan['alasan_penolakan']) ?: '-' ?>
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-light fw-semibold">
        Detail Bahan
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width:50px;">#</th>
                        <th>Nama Bahan</th>
                        <th>Kategori</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($permintaan['details'])): ?>
                        <?php foreach ($permintaan['details'] as $i => $d): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= esc($d['nama']) ?></td>
                                <td><?= esc($d['kategori']) ?></td>
                                <td><?= esc($d['jumlah_diminta']) ?></td>
                                <td><?= esc($d['satuan']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-3">
                                <i class="bi bi-exclamation-circle"></i> Tidak ada bahan
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?= $this->endSection() ?>