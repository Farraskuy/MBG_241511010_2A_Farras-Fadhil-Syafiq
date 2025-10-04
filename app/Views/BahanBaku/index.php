<?php $validation = session()->getFlashdata('errors'); ?>

<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
List Bahan Baku
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="mb-4">
    <h2 class="fw-bold">Bahan Baku List</h2>
    <p class="text-muted">List of registered bahan-baku</p>
</div>

<div class="d-flex flex-wrap justify-content-between w-100 mb-3 gap-1">
    <a href="<?= base_url('bahan-baku/create') ?>" class="btn btn-success fw-semibold"> Add Bahan Baku</a>
    <form class="d-flex gap-3 search" method="get">
        <input value="<?= service('request')->getGet('keyword') ?>"
            type="text" name="keyword" class="form-control form-text m-0" placeholder="Search user...">
        <button type="submit" class="btn btn-primary text-nowrap">Search</button>
    </form>
</div>

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

<div class="bg-white p-4 rounded-3">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Jumlah</th>
                <th>Satuan</th>
                <th>Tanggal Masuk</th>
                <th>Tanggal Kadaluarsa</th>
                <th>Status Bahan Baku</th>
                <th class="text-end">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($bahanbaku) && is_array($bahanbaku)): ?>

                <?php $i = 1;
                foreach ($bahanbaku as $bahan_baku): ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= esc($bahan_baku['nama']) ?></td>
                        <td><?= esc($bahan_baku['kategori']) ?></td>
                        <td><?= esc($bahan_baku['jumlah']) ?></td>
                        <td><?= esc($bahan_baku['satuan']) ?></td>
                        <td><?= esc($bahan_baku['tanggal_masuk']) ?></td>
                        <td><?= esc($bahan_baku['tanggal_kadaluarsa']) ?></td>
                        <td>
                            <?php
                            $today = new DateTime(date("Y-m-d"));
                            $exp   = new DateTime($bahan_baku['tanggal_kadaluarsa']);
                            $diff  = $today->diff($exp)->days; // selisih hari
                            $jumlah = (int) $bahan_baku['jumlah'];

                            if ($jumlah == 0) {
                                echo "<span class='badge bg-secondary'>Habis</span>";
                            } elseif ($today >= $exp) {
                                echo "<span class='badge bg-danger'>Kadaluarsa</span>";
                            } elseif ($diff <= 3 && $jumlah > 0) {
                                echo "<span class='badge bg-warning text-dark'>Segera Kadaluarsa</span>";
                            } else {
                                echo "<span class='badge bg-success'>Tersedia</span>";
                            }
                            ?>
                        </td>

                        <td class="text-end">
                            <div class="d-flex gap-2 flex-wrap justify-content-end">
                                <a href="<?= base_url("bahan-baku/detail/{$bahan_baku['id']}") ?>"
                                    class="btn btn-info btn-sm fw-semibold">Detail</a>


                                <?php if ($today <= $exp): ?>

                                    <a href="<?= base_url("bahan-baku/update/{$bahan_baku['id']}") ?>"
                                        class="btn btn-warning btn-sm fw-semibold">Edit</a>
                                <?php endif ?>

                                <?php if ($today >= $exp): ?>

                                    <!-- Delete Trigger -->
                                    <button class="btn btn-danger btn-sm fw-semibold"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modal-delete-<?= $bahan_baku['id'] ?>">
                                        Delete
                                    </button>

                                    <!-- Modal Delete -->
                                    <div class="modal fade" id="modal-delete-<?= $bahan_baku['id'] ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header border-0">
                                                    <h5 class="modal-title">Delete Confirmation</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete bahan baku
                                                    <strong>"<?= esc($bahan_baku['nama']) ?>"</strong>?
                                                </div>
                                                <form method="post" action="<?= base_url("bahan-baku/delete/{$bahan_baku['id']}") ?>">
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
                            </div>
                        </td>

                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center text-muted">No bahan baku found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>