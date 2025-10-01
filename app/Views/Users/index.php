<?php $validation = session()->getFlashdata('errors'); ?>

<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
List Users
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="mb-4">
    <h2 class="fw-bold">User List</h2>
    <p class="text-muted">List of registered users</p>
</div>

<div class="d-flex flex-wrap justify-content-between w-100 mb-3 gap-1">
    <a href="<?= base_url('users/add') ?>" class="btn btn-success fw-semibold"> Add User</a>
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
                <th>ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Username</th>
                <th>Role</th>
                <th class="text-end">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($users) && is_array($users)): ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= esc($user['id']) ?></td>
                        <td><?= esc($user['full_name']) ?></td>
                        <td><?= esc($user['email']) ?></td>
                        <td><?= esc($user['username']) ?></td>
                        <td><span class="badge bg-secondary"><?= esc($user['role']) ?></span></td>
                        <td class="text-end">
                            <div class="d-flex gap-2 flex-wrap justify-content-end">
                                <a href="<?= base_url("users/detail/{$user['id']}") ?>" class="btn btn-info btn-sm fw-semibold">Detail</a>
                                <a href="<?= base_url("users/update/{$user['id']}") ?>" class="btn btn-warning btn-sm fw-semibold">Edit</a>
                                <a href="<?= base_url("users/update-password/{$user['id']}") ?>" class="btn btn-secondary btn-sm fw-semibold">Password</a>
                                <!-- Delete Trigger -->
                                <button class="btn btn-danger btn-sm fw-semibold"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modal-delete-<?= $user['id'] ?>">
                                    Delete
                                </button>
                            </div>

                            <!-- Modal Delete -->
                            <div class="modal fade" id="modal-delete-<?= $user['id'] ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header border-0">
                                            <h5 class="modal-title">Delete Confirmation</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete user
                                            <strong>"<?= esc($user['full_name']) ?>"</strong>?
                                        </div>
                                        <form method="post" action="<?= base_url("users/delete/{$user['id']}") ?>">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <div class="modal-footer border-0">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-outline-danger">Yes, Delete</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center text-muted">No users found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
