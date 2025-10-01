<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
Update Password User
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="mb-5">
    <h2 class="fw-bold">Update Password</h2>
    <p class="text-muted">Form to update user password</p>
    <a href="<?= base_url("users/update/{$user['id']}") ?>" class="btn btn-secondary">Back</a>
</div>

<h6 class="fw-bold mb-3">User Data</h6>
<table class="table table-bordered table-striped">
    <tbody>
        <tr>
            <th style="width: 200px;">Full Name</th>
            <td><?= esc($user['full_name']) ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?= esc($user['email']) ?></td>
        </tr>
        <tr>
            <th>Username</th>
            <td><?= esc($user['username']) ?></td>
        </tr>
        <tr>
            <th>Role</th>
            <td><?= esc($user['role']) ?></td>
        </tr>
    </tbody>
</table>

<br>
<hr>
<br>

<form action="<?= base_url("users/update-password/{$user['id']}") ?>" method="post">
    <?= csrf_field() ?>
    <input type="hidden" name="_method" value="PUT">

    <div class="mb-3">
        <label for="password" class="form-label">New Password</label>
        <input type="password"
            class="form-control <?= isset($validation['password']) ? 'is-invalid' : '' ?>"
            id="password" name="password" value="<?= old('password') ?>">
        <?php if (isset($validation['password'])): ?>
            <div class="invalid-feedback">
                <?= $validation['password'] ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="repeat_password" class="form-label">Repeat Password</label>
        <input type="password"
            class="form-control <?= isset($validation['repeat_password']) ? 'is-invalid' : '' ?>"
            id="repeat_password" name="repeat_password" value="<?= old('repeat_password') ?>">
        <?php if (isset($validation['repeat_password'])): ?>
            <div class="invalid-feedback">
                <?= $validation['repeat_password'] ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Tombol -->
    <div class="d-flex justify-content-end">
        <button type="reset" class="btn btn-secondary me-2">Reset</button>
        <button type="submit" class="btn btn-warning">Update Password</button>
    </div>
</form>

<?= $this->endSection() ?>
