<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
Detail Bahan Baku
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="mb-4">
    <h2 class="fw-bold">Detail Bahan Baku</h2>
    <p class="text-muted">Informasi lengkap bahan baku</p>
    <a href="<?= base_url("bahan-baku") ?>" class="btn btn-secondary">Back</a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-primary text-white fw-semibold">
        Data Bahan Baku
    </div>
    <div class="card-body p-4">
        <table class="table table-bordered table-striped mb-0">
            <tbody>
                <tr>
                    <th style="width: 200px;">Nama</th>
                    <td><?= esc($bahanbaku['nama']) ?></td>
                </tr>
                <tr>
                    <th>Kategori</th>
                    <td><?= esc($bahanbaku['kategori']) ?></td>
                </tr>
                <tr>
                    <th>Jumlah</th>
                    <td><?= esc($bahanbaku['jumlah']) . ' ' . esc($bahanbaku['satuan']) ?></td>
                </tr>
                <tr>
                    <th>Tanggal Masuk</th>
                    <td><?= esc($bahanbaku['tanggal_masuk']) ?></td>
                </tr>
                <tr>
                    <th>Tanggal Kadaluarsa</th>
                    <td><?= esc($bahanbaku['tanggal_kadaluarsa'] ?? '-') ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
