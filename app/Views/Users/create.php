<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
Add User
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="mb-5">
    <h2 class="fw-bold">Add User</h2>
    <p class="text-muted">Form to add a new user</p>
    <a href="<?= base_url("users") ?>" class="btn btn-secondary">Back</a>
</div>

<form action="<?= base_url('users/create') ?>" method="post">
    <?= csrf_field() ?>

    <div class="mb-3">
        <label for="full_name" class="form-label">Full Name</label>
        <input type="text"
            class="form-control <?= isset($validation['full_name']) ? 'is-invalid' : '' ?>"
            id="full_name" name="full_name" value="<?= old('full_name') ?>">
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
            id="email" name="email" value="<?= old('email') ?>">
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
            id="username" name="username" value="<?= old('username') ?>">
        <?php if (isset($validation['username'])): ?>
            <div class="invalid-feedback">
                <?= $validation['username'] ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password"
            class="form-control <?= isset($validation['password']) ? 'is-invalid' : '' ?>"
            id="password" name="password">
        <?php if (isset($validation['password'])): ?>
            <div class="invalid-feedback">
                <?= $validation['password'] ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="role" class="form-label">Role</label>
        <select id="role" name="role" class="form-select <?= isset($validation['role']) ? 'is-invalid' : '' ?>">
            <option value="">-- Select Role --</option>
            <option value="admin" <?= old('role') === 'admin' ? 'selected' : '' ?>>Admin</option>
            <option value="student" <?= old('role') === 'student' ? 'selected' : '' ?>>Student</option>
            <option value="teacher" <?= old('role') === 'teacher' ? 'selected' : '' ?>>Teacher</option>
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
        <button type="submit" class="btn btn-success">Add User</button>
    </div>
</form>

<?= $this->endSection() ?>
