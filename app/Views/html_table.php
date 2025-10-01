<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Html Table</title>
</head>
<body>
    <table border="1">
        <caption>Table html manual</caption>
        <tr>
            <th>Nama</th>
            <th>Nim</th>
            <th>Kelas</th>
        </tr>
        <tr>
            <td>Asep</td>
            <td>1</td>
            <td>1A</td>
        </tr>
        <tr>
            <td>Agus</td>
            <td>2</td>
            <td>1A</td>
        </tr>
        <tr>
            <td>Aceng</td>
            <td>2</td>
            <td>1A</td>
        </tr>
    </table>


    <?php 
        $items = [
            [
                "nama" => 'Asep',
                "nim" => '1',
                "kelas" => '1A',
            ],
            [
                "nama" => 'Agus',
                "nim" => '2',
                "kelas" => '1A',
            ],
            [
                "nama" => 'Aceng',
                "nim" => '3',
                "kelas" => '1A',
            ],
        ];
    ?>
    <br>
    <br>
    <table border="1">
        <caption>Table html loop item menggunakan php</caption>
        <tr>
            <th>Nama</th>
            <th>Nim</th>
            <th>Kelas</th>
        </tr>
        <?php foreach ($items as $key => $value): ?>
            <tr>
                <td><?= $value['nama'] ?></td>
                <td><?= $value['nim'] ?></td>
                <td><?= $value['kelas'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>