<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
Daftar Permintaan Bahan
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="mb-5">
    <h2 class="fw-bold">Daftar Permintaan Bahan</h2>
    <p class="text-muted">List semua permintaan bahan yang sudah diajukan</p>
</div>

<?php if (session()->has('users') && session()->get('users')['role'] == 'dapur'): ?>
    <div class="d-flex flex-wrap justify-content-between w-100 mb-3 gap-1">
        <a href="<?= base_url('permintaan-bahan/create') ?>" class="btn btn-success fw-semibold">Add Permintaan Bahan</a>
    </div>
<?php endif ?>

<!-- Pesan sukses -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success mb-3">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<!-- Pesan error -->
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger mb-3">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

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
                                <div class="d-flex gap-2 justify-content-end">
                                    <a href="<?= base_url('permintaan-bahan/detail/' . $p['id']) ?>" class="btn btn-sm btn-primary fw-semibold">Detail</a>
                                    <?php if ($p['status'] == 'menunggu' && session()->has('users')): ?>
                                        <?php if (session()->get('users')['role'] == 'gudang'): ?>
                                            <!-- Approve Trigger -->
                                            <button class="btn btn-success btn-sm fw-semibold"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modal-approve-<?= $p['id'] ?>">
                                                Approve
                                            </button>

                                            <!-- Modal Approve -->
                                            <div class="modal fade" id="modal-approve-<?= $p['id'] ?>" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header border-0">
                                                            <h5 class="modal-title">Approve Confirmation</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to approve permintaan bahan
                                                            <strong>"<?= esc($p['menu_makan']) ?>"</strong>?
                                                        </div>
                                                        <form method="post" action="<?= base_url("permintaan-bahan/approve/{$p['id']}") ?>">

                                                            <div class="modal-footer border-0">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-outline-success">Yes, Approve</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Reject Trigger -->
                                            <button class="btn btn-danger btn-sm fw-semibold"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modal-reject-<?= $p['id'] ?>">
                                                Reject
                                            </button>

                                            <!-- Modal Reject -->
                                            <div class="modal fade" id="modal-reject-<?= $p['id'] ?>" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <form class="modal-content" method="post" action="<?= base_url("permintaan-bahan/reject/{$p['id']}") ?>">
                                                        <div class="modal-header border-0">
                                                            <h5 class="modal-title">Reject Confirmation</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body" style="text-align:left">
                                                            Are you sure you want to reject permintaan bahan
                                                            <strong>"<?= esc($p['menu_makan']) ?>"</strong>?

                                                            <div class="mb-3">
                                                                <label for="alasan-<?= $p['id'] ?>" class="form-label">Reason for Rejection</label>
                                                                <textarea name="alasan_penolakan" id="alasan-<?= $p['id'] ?>" class="form-control" rows="3" required></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer border-0">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-outline-danger">Yes, Reject</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <?php if (session()->get('users')['role'] == 'dapur'): ?>
                                            <!-- Delete Trigger -->
                                            <button class="btn btn-danger btn-sm fw-semibold"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modal-delete-<?= $p['id'] ?>">
                                                Delete
                                            </button>

                                            <!-- Modal Delete -->
                                            <div class="modal fade" id="modal-delete-<?= $p['id'] ?>" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header border-0">
                                                            <h5 class="modal-title">Delete Confirmation</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to delete permintaan bahan
                                                            <strong>"<?= esc($p['menu_makan']) ?>"</strong>?
                                                        </div>
                                                        <form method="post" action="<?= base_url("permintaan-bahan/delete/{$p['id']}") ?>">
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <div class="modal-footer border-0">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-outline-danger">Yes, Delete</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
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