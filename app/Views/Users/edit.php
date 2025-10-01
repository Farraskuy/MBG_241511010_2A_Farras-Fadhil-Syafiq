<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
Update User
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="mb-5">
    <h2 class="fw-bold">Update User</h2>
    <p class="text-muted">Form to update user data</p>
    <div class="d-flex justify-content-between flex-wrap">
        <a href="<?= base_url("users") ?>" class="btn btn-secondary">Back</a>
        <a href="<?= base_url("users/update-password/{$user['id']}") ?>" class="btn btn-warning fw-semibold">Update Password</a>
    </div>
</div>

<form action="<?= base_url("users/update/{$user['id']}") ?>" method="post">
    <?= csrf_field() ?>
    <input type="hidden" name="_method" value="PUT">

    <div class="mb-3">
        <label for="full_name" class="form-label">Full Name</label>
        <input type="text"
            class="form-control <?= isset($validation['full_name']) ? 'is-invalid' : '' ?>"
            id="full_name" name="full_name" 
            value="<?= old('full_name', $user['full_name']) ?>">
        <?php if (isset($validation['full_name'])): ?>
            <div class="invalid-feedback">
                <?= $validation['full_name'] ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email"
            class="form-control <?= isset($validation['email']) ? 'is-invalid' : '' ?>"
            id="email" name="email" 
            value="<?= old('email', $user['email']) ?>">
        <?php if (isset($validation['email'])): ?>
            <div class="invalid-feedback">
                <?= $validation['email'] ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text"
            class="form-control <?= isset($validation['username']) ? 'is-invalid' : '' ?>"
            id="username" name="username" 
            value="<?= old('username', $user['username']) ?>">
        <?php if (isset($validation['username'])): ?>
            <div class="invalid-feedback">
                <?= $validation['username'] ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="role" class="form-label">Role</label>
        <select class="form-select <?= isset($validation['role']) ? 'is-invalid' : '' ?>"
                id="role" name="role">
            <option value="admin" <?= old('role', $user['role']) === 'admin' ? 'selected' : '' ?>>Admin</option>
            <option value="student" <?= old('role', $user['role']) === 'student' ? 'selected' : '' ?>>Student</option>
            <option value="teacher" <?= old('role', $user['role']) === 'teacher' ? 'selected' : '' ?>>Teacher</option>
        </select>
        <?php if (isset($validation['role'])): ?>
            <div class="invalid-feedback">
                <?= $validation['role'] ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Tombol -->
    <div class="d-flex justify-content-end">
        <button type="reset" class="btn btn-secondary me-2">Reset</button>
        <button type="submit" class="btn btn-warning">Update User</button>
    </div>
</form>

<?= $this->endSection() ?>
