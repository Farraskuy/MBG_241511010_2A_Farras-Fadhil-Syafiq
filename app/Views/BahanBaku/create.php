<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
Add Bahan Baku
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="mb-5">
    <h2 class="fw-bold">Add Bahan Baku</h2>
    <p class="text-muted">Form to add a new user</p>
    <a href="<?= base_url("bahan-baku") ?>" class="btn btn-secondary">Back</a>
</div>

<form action="<?= base_url('bahan-baku/create') ?>" method="post">
    <?= csrf_field() ?>

    <!-- Nama -->
    <div class="mb-3">
        <label for="nama" class="form-label">Nama</label>
        <input type="text"
            class="form-control <?= isset($validation['nama']) ? 'is-invalid' : '' ?>"
            id="nama" name="nama" value="<?= old('nama') ?>">
        <?php if (isset($validation['nama'])): ?>
            <div class="invalid-feedback">
                <?= $validation['nama'] ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Kategori -->
    <div class="mb-3">
        <label for="kategori" class="form-label">Kategori</label>
        <input type="text"
            class="form-control <?= isset($validation['kategori']) ? 'is-invalid' : '' ?>"
            id="kategori" name="kategori" value="<?= old('kategori') ?>">
        <?php if (isset($validation['kategori'])): ?>
            <div class="invalid-feedback">
                <?= $validation['kategori'] ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Jumlah -->
    <div class="mb-3">
        <label for="jumlah" class="form-label">Jumlah</label>
        <input type="number"
            class="form-control <?= isset($validation['jumlah']) ? 'is-invalid' : '' ?>"
            id="jumlah" name="jumlah" value="<?= old('jumlah') ?>">
        <?php if (isset($validation['jumlah'])): ?>
            <div class="invalid-feedback">
                <?= $validation['jumlah'] ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Satuan -->
    <div class="mb-3">
        <label for="satuan" class="form-label">Satuan</label>
        <input type="text"
            class="form-control <?= isset($validation['satuan']) ? 'is-invalid' : '' ?>"
            id="satuan" name="satuan" value="<?= old('satuan') ?>">
        <?php if (isset($validation['satuan'])): ?>
            <div class="invalid-feedback">
                <?= $validation['satuan'] ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Tanggal Masuk -->
    <div class="mb-3">
        <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
        <input type="date"
            class="form-control <?= isset($validation['tanggal_masuk']) ? 'is-invalid' : '' ?>"
            id="tanggal_masuk" name="tanggal_masuk" value="<?= old('tanggal_masuk') ?>">
        <?php if (isset($validation['tanggal_masuk'])): ?>
            <div class="invalid-feedback">
                <?= $validation['tanggal_masuk'] ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Tanggal Kadaluarsa -->
    <div class="mb-3">
        <label for="tanggal_kadaluarsa" class="form-label">Tanggal Kadaluarsa</label>
        <input type="date"
            class="form-control <?= isset($validation['tanggal_kadaluarsa']) ? 'is-invalid' : '' ?>"
            id="tanggal_kadaluarsa" name="tanggal_kadaluarsa" value="<?= old('tanggal_kadaluarsa') ?>">
        <?php if (isset($validation['tanggal_kadaluarsa'])): ?>
            <div class="invalid-feedback">
                <?= $validation['tanggal_kadaluarsa'] ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Tombol -->
    <div class="d-flex justify-content-end">
        <button type="reset" class="btn btn-secondary me-2">Reset</button>
        <button type="button" class="btn btn-success btn-sm fw-semibold"
            data-bs-toggle="modal"
            data-bs-target="#modal-konfirmasi">
            Add Bahan Baku
        </button>

        <!-- Modal Konfirmasi -->
        <div class="modal fade" id="modal-konfirmasi" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h5 class="modal-title">Add Confirmation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to add this bahan baku?
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-outline-success">Yes, Add Bahan Baku</button>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</form>

<?= $this->endSection() ?>
