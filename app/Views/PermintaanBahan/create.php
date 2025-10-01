<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
Add Permintaan Bahan
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="mb-5">
    <h2 class="fw-bold">Add Permintaan Bahan</h2>
    <p class="text-muted">Form to add a new permintaan bahan</p>
    <a href="<?= base_url("permintaan-bahan") ?>" class="btn btn-secondary">Back</a>
</div>

<!-- Tabel Bahan yang dipilih -->
<div class="mb-5">
    <div class="d-flex justify-content-between mb-3">
        <h5 class="fw-bold">Daftar Bahan</h5>
        <button type="button" class="btn btn-primary btn-sm"
            data-bs-toggle="modal" data-bs-target="#modal-bahan">
            Tambah Bahan
        </button>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr class="table-secondary">
                <th>Nama</th>
                <th>Kategori</th>
                <th>Jumlah</th>
                <th>Satuan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty(session('bahan_terpilih'))): ?>
                <?php foreach (session('bahan_terpilih') as $index => $bahan): ?>
                    <tr>
                        <td><?= esc($bahan['nama']) ?></td>
                        <td><?= esc($bahan['kategori']) ?></td>
                        <td><?= esc($bahan['jumlah']) ?></td>
                        <td><?= esc($bahan['satuan']) ?></td>
                        <td>
                            <form action="<?= base_url("permintaan-bahan/remove-bahan/" . $bahan['id']) ?>" method="post">
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center text-muted">Belum ada bahan ditambahkan</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<form action="<?= base_url('permintaan-bahan/create') ?>" method="post">
    <?= csrf_field() ?>

    <!-- Menu Makanan -->
    <div class="mb-3">
        <label for="menu_makan" class="form-label">Menu Makanan</label>
        <input type="text"
            class="form-control <?= isset($validation['menu_makan']) ? 'is-invalid' : '' ?>"
            id="menu_makan" name="menu_makan"
            value="<?= old('menu_makan') ?>">
        <?php if (isset($validation['menu_makan'])): ?>
            <div class="invalid-feedback"><?= $validation['menu_makan'] ?></div>
        <?php endif; ?>
    </div>

    <!-- Jumlah Porsi -->
    <div class="mb-3">
        <label for="jumlah_porsi" class="form-label">Jumlah Porsi</label>
        <input type="number"
            class="form-control <?= isset($validation['jumlah_porsi']) ? 'is-invalid' : '' ?>"
            id="jumlah_porsi" name="jumlah_porsi"
            value="<?= old('jumlah_porsi') ?>">
        <?php if (isset($validation['jumlah_porsi'])): ?>
            <div class="invalid-feedback"><?= $validation['jumlah_porsi'] ?></div>
        <?php endif; ?>
    </div>

    <!-- Tanggal Masuk -->
    <div class="mb-3">
        <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
        <input type="date"
            class="form-control <?= isset($validation['tanggal_masuk']) ? 'is-invalid' : '' ?>"
            id="tanggal_masuk" name="tanggal_masuk"
            value="<?= old('tanggal_masuk') ?>">
        <?php if (isset($validation['tanggal_masuk'])): ?>
            <div class="invalid-feedback"><?= $validation['tanggal_masuk'] ?></div>
        <?php endif; ?>
    </div>

    <!-- Tombol Simpan -->
    <div class="d-flex justify-content-end">
        <button type="reset" class="btn btn-secondary me-2">Reset</button>
        <button type="submit" class="btn btn-success">Simpan Permintaan</button>
    </div>
</form>

<!-- Modal Pilih Bahan -->
<div class="modal fade" id="modal-bahan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title">Pilih Bahan Baku</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Jumlah Stok</th>
                            <th>Satuan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bahan_baku as $bahan): ?>
                            <tr>
                                <td><?= esc($bahan['nama']) ?></td>
                                <td><?= esc($bahan['kategori']) ?></td>
                                <td><?= esc($bahan['jumlah']) ?></td>
                                <td><?= esc($bahan['satuan']) ?></td>
                                <td>
                                    <button type="button"
                                        class="btn btn-sm btn-success"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modal-input-bahan"
                                        data-id="<?= $bahan['id'] ?>"
                                        data-nama="<?= esc($bahan['nama']) ?>"
                                        data-satuan="<?= esc($bahan['satuan']) ?>">
                                        Add
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Input Jumlah Permintaan -->
<div class="modal fade" id="modal-input-bahan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="formAddBahan" method="post">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title">Input Jumlah Permintaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="bahan_id">
                    <div class="mb-3">
                        <label class="form-label">Nama Bahan</label>
                        <input type="text" class="form-control" id="bahan_nama" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah</label>
                        <input type="number" name="jumlah" class="form-control" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Satuan</label>
                        <input type="text" name="satuan" class="form-control" id="bahan_satuan" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Tambahkan</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?= $this->endSection() ?>



<?= $this->section('script') ?>
<script>
    const modalInput = document.getElementById('modal-input-bahan');
    modalInput.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const nama = button.getAttribute('data-nama');
        const satuan = button.getAttribute('data-satuan');

        // set form action dinamis
        const form = modalInput.querySelector('#formAddBahan');
        form.action = "<?= base_url('permintaan-bahan/add-bahan/') ?>" + id;

        // isi field
        modalInput.querySelector('#bahan_id').value = id;
        modalInput.querySelector('#bahan_nama').value = nama;
        modalInput.querySelector('#bahan_satuan').value = satuan;
    });
</script>

<?= $this->endSection() ?>