<?php

require_once 'get_data.php';

$year = date('Y');
$previous_year = date('Y', strtotime('-1 year'));

// bulan
$bulana = [
    '01' => 'jan',
    '02' => 'feb',
    '03' =>  'mar',
    '04' =>  'apr',
    '05' =>  'mei',
    '06' =>  'jun',
    '07' =>  'jul',
    '08' =>  'ags',
    '09' =>  'sep',
    '10' =>  'okt',
    '11' =>  'nov',
    '12' =>  'des'
];

if (isset($_POST['lihat'])) {
    $tahun = $_POST['tahun'];
    $transaksi = transaksi($tahun);
    $menu = menu();
}

?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

    <title>Tes Venturo</title>
</head>

<body>

    <div class="container">

        <div class="card mt-5">
            <div class="card-header">
                Laporan
            </div>
            <div class="card-body">
                <form action="" method="POST">
                </form>
                <form class="form-inline" action="" method="POST">

                    <select class="custom-select mb-2 mr-sm-2" name="tahun" required>
                        <option value="">Pilih Tahun</option>
                        <option value="<?= $previous_year ?>"><?= $previous_year ?></option>
                        <option value="<?= $year ?>"><?= $year ?></option>
                    </select>

                    <button name="lihat" class="btn btn-primary mb-2 btn-sm" type="submit">Lihat</button>
                </form>
                <?php if (isset($_POST['lihat'])) : ?>
                    <hr>
                    <?php
                    $result = array_intersect($menu[0], $transaksi[0]);
                    print_r($result);
                    ?>
                    <table class="table table-sm text-center">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col" rowspan="2">Menu</th>
                                <th colspan="12">Periode Tahun <?= $tahun ?></th>
                                <th rowspan="2">Total</th>
                            </tr>
                            <tr>
                                <?php foreach ($bulana as $bln) : ?>
                                    <th><?= ucfirst($bln) ?></th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $bul = array_flip($bulana);
                            ?>
                            <?php foreach ($menu as $mn) : ?>
                                <tr>
                                    <td scope="row"><?= $mn['menu']; ?></td>
                                    <?php
                                    foreach ($bul as $b) {
                                        $bulan[$b] = [];
                                    }
                                    foreach ($transaksi as $tr) :
                                        $bulanTahun = date('m-Y', strtotime($tr['tanggal']));
                                        if ($tr['menu'] == $mn['menu']) {
                                            if ($bulanTahun == '01-' . $tahun) {
                                                $bulan['01'][] = $tr['total'];
                                            }
                                            if ($bulanTahun == '02-' . $tahun) {
                                                $bulan['02'][] = $tr['total'];
                                            }
                                            if ($bulanTahun == '03-' . $tahun) {
                                                $bulan['03'][] = $tr['total'];
                                            }
                                            if ($bulanTahun == '04-' . $tahun) {
                                                $bulan['04'][] = $tr['total'];
                                            }
                                            if ($bulanTahun == '05-' . $tahun) {
                                                $bulan['05'][] = $tr['total'];
                                            }
                                            if ($bulanTahun == '06-' . $tahun) {
                                                $bulan['06'][] = $tr['total'];
                                            }
                                            if ($bulanTahun == '07-' . $tahun) {
                                                $bulan['07'][] = $tr['total'];
                                            }
                                            if ($bulanTahun == '08-' . $tahun) {
                                                $bulan['08'][] = $tr['total'];
                                            }
                                            if ($bulanTahun == '09-' . $tahun) {
                                                $bulan['09'][] = $tr['total'];
                                            }
                                            if ($bulanTahun == '10-' . $tahun) {
                                                $bulan['10'][] = $tr['total'];
                                            }
                                            if ($bulanTahun == '11-' . $tahun) {
                                                $bulan['11'][] = $tr['total'];
                                            }
                                            if ($bulanTahun == '12-' . $tahun) {
                                                $bulan['12'][] = $tr['total'];
                                            }
                                        }
                                    endforeach;
                                    echo '<td>' . number_format(array_sum($bulan['01'])) . '</td>';
                                    echo '<td>' . number_format(array_sum($bulan['02'])) . '</td>';
                                    echo '<td>' . number_format(array_sum($bulan['03'])) . '</td>';
                                    echo '<td>' . number_format(array_sum($bulan['04'])) . '</td>';
                                    echo '<td>' . number_format(array_sum($bulan['05'])) . '</td>';
                                    echo '<td>' . number_format(array_sum($bulan['06'])) . '</td>';
                                    echo '<td>' . number_format(array_sum($bulan['07'])) . '</td>';
                                    echo '<td>' . number_format(array_sum($bulan['08'])) . '</td>';
                                    echo '<td>' . number_format(array_sum($bulan['09'])) . '</td>';
                                    echo '<td>' . number_format(array_sum($bulan['10'])) . '</td>';
                                    echo '<td>' . number_format(array_sum($bulan['11'])) . '</td>';
                                    echo '<td>' . number_format(array_sum($bulan['12'])) . '</td>';
                                    ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>


    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
    -->
</body>

</html>