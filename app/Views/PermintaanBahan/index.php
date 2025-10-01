<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
Daftar Permintaan Bahan
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="mb-5">
    <h2 class="fw-bold">Daftar Permintaan Bahan</h2>
    <p class="text-muted">List semua permintaan bahan yang sudah diajukan</p>
</div>

<div class="d-flex flex-wrap justify-content-between w-100 mb-3 gap-1">
    <a href="<?= base_url('permintaan-bahan/create') ?>" class="btn btn-success fw-semibold">Add Permintaan Bahan</a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Menu Makanan</th>
                    <th>Jumlah Porsi</th>
                    <th>Tanggal Masuk</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($permintaan)): ?>
                    <?php foreach ($permintaan as $i => $p): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= esc($p['menu_makan']) ?></td>
                            <td><?= esc($p['jumlah_porsi']) ?></td>
                            <td><?= esc($p['created_at']) ?></td>
                            <td>
                                <?php if ($p['status'] == 'menunggu'): ?>
                                    <span class="badge bg-warning text-dark">Pending</span>
                                <?php elseif ($p['status'] == 'disetujui'): ?>
                                    <span class="badge bg-success">Approved</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Rejected</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <?php if ($p['status'] == 'menunggu' && session()->has('users') && session()->get('users')['role'] == 'gudang'): ?>
                                    <div class="d-flex gap-2 justify-content-end">
                                        <!-- Approve -->
                                        <form action="<?= base_url("permintaan-bahan/approve/{$p['id']}") ?>" method="post">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                        </form>
                                        <!-- Reject -->
                                        <form action="<?= base_url("permintaan-bahan/reject/{$p['id']}") ?>" method="post">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                        </form>
                                    </div>
                                <?php else: ?>
                                    <em class="text-muted">Tidak ada aksi</em>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted">Belum ada pengajuan permintaan</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>