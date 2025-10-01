<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>

<?= $this->section('content') ?>


<h2 class="fw-bold">Dashboard</h2>
<p class="text-muted">Selamat datang, <strong><?= session('users')['username'] ?></strong></p>


<?= $this->endSection() ?>

<?= $this->section('script') ?>
<!-- <script>
    // Data untuk Project Progress Chart
    const progressCtx = document.getElementById('projectProgressChart').getContext('2d');
    const projectProgressChart = new Chart(progressCtx, {
        type: 'doughnut',
        data: {
            labels: ['Completed', 'In Progress', 'Pending'],
            datasets: [{
                label: 'Project Progress',
                data: [41, 30, 29], // 41% completed
                backgroundColor: ['#198754', '#ffc107', '#dc3545'],
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            cutout: '75%', // Membuat lubang donat lebih besar
            plugins: {
                legend: {
                    display: false // Sembunyikan legenda default
                },
                tooltip: {
                    enabled: true
                }
            }
        }
    });
</script> -->
<?= $this->endSection() ?>