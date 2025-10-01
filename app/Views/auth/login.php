<?= $this->extend('auth/layout') ?>

<?= $this->section('title') ?>
Masuk ke akun
<?= $this->endSection() ?>

<?= $this->section('content') ?>


<!-- Card Login -->
<div class="card shadow-lg border-0 rounded-4 p-4 me-0 me-sm-5" style="width: 380px; background: rgba(255,255,255,0.9);">
    <div class="gap-3 d-flex mb-4 align-items-center flex-wrap flex-sm-nowrap">
        <img src="<?= base_url("") ?>assets/img/189982191_17242e90-fe2c-4ea2-be5c-1f50c2df067b.jpg" alt="Logo polban" class="mb-2 bg-white rounded-3 p-3" height="65" width="65">
        <div class="d-flex flex-column justify-content-center">
            <h5 class="fw-semibold m-0">TheCrud</h5>
            <p class="text-muted text-secondary m-0">Sistem CRUD</p>
        </div>
    </div>

    <h1 class="fs-4 fw-medium mb-4">Masuk</h1>


    <form method="post" class="w-100 data" alert="true">
        <div class="alert alert-danger d-none">
            <?php if (session()->has('error')): ?>
                <?= session()->getFlashdata('error') ?>
            <?php endif ?>
        </div>

        <?= csrf_field() ?>

        <div class="form-floating mb-3">
            <input type="text" id="name" name="name" class="form-control rounded-3 <?= isset($validation['name']) ? 'is-invalid' : '' ?>" placeholder="name atau email" value="<?= old("name", "") ?>">
            <label for="name">Name / Email</label>
            <?php if (isset($validation['name'])):  ?>
                <div class="invalid-feedback">
                    <?= $validation['name'] ?>
                </div>
            <?php endif ?>
        </div>

        <div class="form-floating mb-3">
            <input type="password" id="password" name="password" class="form-control rounded-3 <?= isset($validation['password']) ? 'is-invalid' : '' ?>" placeholder="Password" value="<?= old("password", "") ?>">
            <label for="password">Password</label>
            <?php if (isset($validation['password'])):  ?>
                <div class="invalid-feedback">
                    <?= $validation['password'] ?>
                </div>
            <?php endif ?>
        </div>

        <!-- <div class="mb-3 small">
                <a href="#" class="text-decoration-none">Lupa password?</a>
            </div> -->

        <button type="submit" class="btn btn-primary fw-semibold rounded-pill w-100 py-2">
            Masuk
        </button>
    </form>
</div>

<?= $this->endSection('content') ?>