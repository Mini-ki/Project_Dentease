<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CETAK LAPORAN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            text-align: center;
            font-family: 'Times New Roman', Times, serif;
        }
        .header {
            margin-bottom: 20px;
        }
        .lineHeader {
            border-bottom: 3px solid black;
        }
        .table-bordered {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table-bordered th,
        .table-bordered td {
            border: 1px solid black;
            padding: 8px;
            font-size: 12px;
            text-align: center;
        }
        .grafik {
            margin-top: 30px;
            page-break-before: always; /* Ensure chart starts on new page for print */
        }
        @media print {
            .btn {
                display: none; /* Hide buttons when printing */
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>DENTEASE</h1>
        <h2>KLINIK KESEHATAN GIGI</h2>
        <p>Alamat: Jl. MataramJaya No 12, Kota Mataram, Nusa Tenggara Barat</p>
        <p>Email: dentease@gmail.com</p>
        <div class="lineHeader" style="border-bottom: 5px solid black; margin-bottom: 5px;"></div>
        <div class="lineHeader"></div>
        <br>
    </div>
    <div class="table-data">
        <h2>LAPORAN DATA KONSULTASI DENTEASE TAHUN {{ $tahun }}</h2>
        <br>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Layanan</th>
                    <th>Januari</th>
                    <th>Februari</th>
                    <th>Maret</th>
                    <th>April</th>
                    <th>Mei</th>
                    <th>Juni</th>
                    <th>Juli</th>
                    <th>Agustus</th>
                    <th>September</th>
                    <th>Oktober</th>
                    <th>November</th>
                    <th>Desember</th>
                </tr>
            </thead>
            <tbody>
                @php $urut = 1; @endphp
                @foreach($tableData as $dataQuery)
                    <tr>
                        <td>{{ $urut++ }}</td>
                        <td>{{ $dataQuery->layanan }}</td>
                        <td>{{ $dataQuery->Jan }}</td>
                        <td>{{ $dataQuery->Feb }}</td>
                        <td>{{ $dataQuery->Mar }}</td>
                        <td>{{ $dataQuery->Apr }}</td>
                        <td>{{ $dataQuery->Mei }}</td>
                        <td>{{ $dataQuery->Jun }}</td>
                        <td>{{ $dataQuery->Jul }}</td>
                        <td>{{ $dataQuery->Agu }}</td>
                        <td>{{ $dataQuery->Sep }}</td>
                        <td>{{ $dataQuery->Okt }}</td>
                        <td>{{ $dataQuery->Nov }}</td>
                        <td>{{ $dataQuery->Des }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br>
        <div class="grafik">
            <div class="head">
                <h3>GRAFIK KONSULTASI</h3>
            </div>
            <br>
            <canvas id="myLineChart" width="400" height="200"></canvas>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        window.chartData = {
            labels: <?php echo json_encode($bulanList); ?>,
            layananList: <?php echo json_encode($layananList); ?>,
            rawData: <?php echo json_encode($chartData); ?>
        };
    </script>
    <script src="{{ asset('asset/js/admin/laporan.js') }}"></script>
    <script>
        setTimeout(() => {
            window.print();
        }, 500);
    </script>
</body>
</html>