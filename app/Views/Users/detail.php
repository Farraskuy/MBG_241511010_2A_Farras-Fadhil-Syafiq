<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
Detail User
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="mb-4">
    <h2 class="fw-bold">User Detail</h2>
    <p class="text-muted">Detail information of user</p>
    <a href="<?= base_url("users") ?>" class="btn btn-secondary">Back</a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-primary text-white fw-semibold">
        User Data
    </div>
    <div class="card-body p-4">
        <table class="table table-bordered table-striped mb-0">
            <tbody>
                <tr>
                    <th style="width: 200px;">Full Name</th>
                    <td><?= esc($user['name']) ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?= esc($user['email']) ?></td>
                </tr>
                <tr>
                    <th>User</th>
                    <td><?= esc($user['name']) ?></td>
                </tr>
                <tr>
                    <th>Role</th>
                    <td>
                        <?php if ($user['role'] === 'admin'): ?>
                            <span class="badge bg-danger">Admin</span>
                        <?php elseif ($user['role'] === 'teacher'): ?>
                            <span class="badge bg-info">Teacher</span>
                        <?php else: ?>
                            <span class="badge bg-success">Student</span>
                        <?php endif; ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
