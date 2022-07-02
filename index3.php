<?php

require_once 'get_data.php';

$year = date('Y');
$previous_year = date('Y', strtotime('-1 year'));

// bulan
$_bulan = [
    "01" => 'jan',
    "02" => 'feb',
    "03" =>  'mar',
    "04" =>  'apr',
    "05" =>  'mei',
    "06" =>  'jun',
    "07" =>  'jul',
    "08" =>  'ags',
    "09" =>  'sep',
    "10" =>  'okt',
    "11" =>  'nov',
    "12" =>  'des'
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
                    <table class="table table-sm table-striped table-bordered table-hover" cellpadding="5">
                        <thead class="thead-dark text-center">
                            <tr>
                                <th scope="col" rowspan="2">Menu</th>
                                <th colspan="12">Periode Tahun <?= $tahun ?></th>
                                <th rowspan="2">Total</th>
                            </tr>
                            <tr>
                                <?php foreach ($_bulan as $_kode_bulan => $_nama_bulan) : ?>
                                    <!-- vertikal atas ke bawah -->
                                    <?php $total[$_kode_bulan] = 0; ?>
                                    <!-- total transaksi per bulan vertikal atas ke bawah -->
                                    <?php $totalBulan[$_kode_bulan] = 0; ?>
                                    <th><?= ucfirst($_nama_bulan) ?></th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result = array();
                            foreach ($menu as $mn) {
                                // makanan
                                // nasi goreng
                                foreach ($_bulan as $_kode_bulan => $_nama_bulan) {
                                    // total["01"] = 0;
                                    $total[$_kode_bulan] = 0;
                                    // $result["makanan"]["nasi goreng"][01"] = 0;
                                    $result[$mn['kategori']][$mn['menu']][$_kode_bulan] = 0;
                                    foreach ($transaksi as $tr_key => $tr) {
                                        // "nasi goreng" == "nasi goreng" && date('m-Y', strtotime($tr['tanggal'])) == "01-2021"
                                        if ($mn['menu'] == $tr['menu'] && date('m-Y', strtotime($tr['tanggal'])) == "$_kode_bulan-$tahun") {
                                            // $total["01"] += 30.000
                                            $total[$_kode_bulan] += $tr['total'];
                                            // $result["makanan"]["nasi goreng"]["01"] = $total["01"];
                                            // $result[$mn['kategori']][$mn['menu']][$_kode_bulan] = $total[$_kode_bulan];
                                            $result[$mn['kategori']][$mn['menu']][$_kode_bulan] += $tr['total'];
                                        }
                                    }
                                    $totalBulan[$_kode_bulan] += $result[$mn['kategori']][$mn['menu']][$_kode_bulan];
                                    $totalMenu[$mn['menu']] = array_sum($result[$mn['kategori']][$mn['menu']]);
                                }
                            }
                            ?>
                            <?php foreach ($result as $kategori => $menu) : ?>
                                <?php echo '<tr><td colspan="14">' . ucfirst($kategori) . '</td></tr>' ?>
                                <?php foreach ($menu as $mn_key => $mn) : ?>
                                    <?= '<tr>'; ?>
                                    <?php echo '<td>' . $mn_key . '</td>' ?>
                                    <?php foreach ($_bulan as $_kode_bulan => $_nama_bulan) : ?>
                                        <?php if (array_key_exists($_kode_bulan, $mn)) : ?>
                                            <?php echo '<td>' . number_format($mn[$_kode_bulan]) . '</td>' ?>
                                        <?php else : ?>
                                            <?php echo '<td>' . number_format($mn[$_kode_bulan] = 0) . '</td>' ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    <?php echo '<td>' . number_format($totalMenu[$mn_key]) . '</td>' ?>
                                    <?= '</tr>'; ?>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                            <tr class="bg-dark text-white">
                                <td>Total</td>
                                <?php foreach ($_bulan as $_kode_bulan => $_nama_bulan) : ?>
                                    <?php echo '<td>' . number_format($totalBulan[$_kode_bulan]) . '</td>' ?>
                                <?php endforeach; ?>
                                <td><?= number_format(array_sum($totalMenu)); ?></td>
                            </tr>
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