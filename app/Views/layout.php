<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->renderSection("title") ?></title>

    <!-- font -->
    <link href="<?= base_url("assets/fonts/fonts.css") ?>" rel="stylesheet">

    <!-- icons -->
    <link href="<?= base_url("assets/icons/font-awesome/css/fontawesome.css") ?>" rel="stylesheet">
    <link href="<?= base_url("assets/icons/font-awesome/css/light.css") ?>" rel="stylesheet">
    <link href="<?= base_url("assets/icons/font-awesome/css/regular.css") ?>" rel="stylesheet">
    <link href="<?= base_url("assets/icons/font-awesome/css/solid.css") ?>" rel="stylesheet">
    <link href="<?= base_url("assets/icons/font-awesome/css/duotone.css") ?>" rel="stylesheet">

    <!-- style -->
    <link href="<?= base_url("assets/css/bootstrap.min.css") ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url("assets/css/global-style.css") ?>">
    <link rel="stylesheet" href="<?= base_url("assets/css/layout.css") ?>">

    <?= $this->renderSection('style') ?>

    <script>
        const baseURL = `<?= base_url() ?>`;
        const currentURL = `<?= current_url() ?>`;
        const csrf = `<?= csrf_token() ?>`;
    </script>
</head>

<body class="layout-wrapper vh-100">

    <!-- sidbar -->
    <aside class="position-fixed sidebar p-3">
        <div class="gap-3 d-flex mb-4 align-items-center flex-wrap flex-sm-nowrap">
            <img src="<?= base_url("") ?>assets/img/189982191_17242e90-fe2c-4ea2-be5c-1f50c2df067b.jpg" alt="Logo polban" class="mb-2 bg-white rounded-3 p-3" height="65" width="65">
            <div class="d-flex flex-column justify-content-center">
                <h5 class="fw-semibold m-0">TheCRUD</h5>
                <p class="text-muted text-secondary m-0">Sistem CRUD</p>
            </div>
        </div>

        <p class="text-muted small text-uppercase ps-3">Menu Utama</p>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="<?= base_url('/') ?>" class="nav-link <?= service('uri')->getSegment(1) == ''  ? 'active' : '' ?>" aria-current="page">
                    Dashboard
                </a>
            </li>
            <?php if (session()->has('users') && session()->get('users')['role'] == 'gudang'): ?>
                <!-- <li class="nav-item">
                    <a href="<?= base_url('/users') ?>" class="nav-link <?= service('uri')->getSegment(1) == 'users' ? 'active' : '' ?>" aria-current="page">
                        Users
                    </a>
                </li> -->
                <li class="nav-item">
                    <a href="<?= base_url('/bahan-baku') ?>" class="nav-link <?= service('uri')->getSegment(1) == 'bahan-baku' ? 'active' : '' ?>" aria-current="page">
                        Bahan Baku
                    </a>
                </li>
            <?php endif ?>
            <li class="nav-item">
                <a href="<?= base_url('/permintaan-bahan') ?>" class="nav-link <?= service('uri')->getSegment(1) == 'permintaan-bahan' ? 'active' : '' ?>" aria-current="page">
                    Permintaan Bahan
                </a>
            </li>
        </ul>
    </aside>

    <main class="p-4 pt-3 flex-grow-1 position-relative overflow-auto vh-100">
        <nav class="navbar navbar-expand-lg bg-white position-sticky py-2 rounded-4 mb-3 shadow" style="left: 0; right: 0; top: 0; z-index: 999;">
            <div class="container-fluid">
                <!-- Sidebar Toggle -->
                <button class="btn btn-outline-light btn-toggle-sidebar" type="button">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Profile Dropdown -->
                <div class="dropdown ms-auto">
                    <button class="btn d-flex align-items-center dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://ui-avatars.com/api/?name=<?= urlencode(session()->get('users')['name']) ?>&background=random&color=fff&size=32"
                            class="rounded-circle me-2" width="32" height="32" alt="profile">
                        <span class="fw-semibold"><?= esc(session()->get('users')['name']) ?></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow">
                        <li>
                            <button data-bs-toggle="modal" data-bs-target="#modal-logout" class="dropdown-item text-danger">Logout</button>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>


        <div class="modal fade" id="modal-logout" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h1 class="modal-title fs-5" id="exampleModalToggleLabel">konfirmasi Logout</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah anda yakin akan logout?
                    </div>
                    <form method="post" action="<?= base_url('logout') ?>" class="modal-footer border-0 data">
                        <?= csrf_field() ?>

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-outline-danger">Ya, Logout</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4 w-100">
            <div class="py-3 px-4 w-100">
                <?= $this->renderSection('content') ?>
            </div>
        </div>
    </main>


    <script src="<?= base_url("assets/js/popper.min.js") ?>"></script>
    <script src="<?= base_url("assets/js/bootstrap.min.js") ?>"></script>

    <!-- <script src="<?= base_url("assets/js/global-script.js") ?>"></script> -->

    <script src="<?= base_url("assets/js/layout.js") ?>"></script>

    <?= $this->renderSection('script') ?>
</body>

</html>