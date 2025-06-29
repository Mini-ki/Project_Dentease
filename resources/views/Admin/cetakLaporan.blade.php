<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>CETAK LAPORAN</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            text-align: center;
            margin: 20px;
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
            page-break-inside: avoid;
        }

        .table-data {
            page-break-inside: avoid;
        }

        @media print {
            .btn, .no-print {
                display: none !important;
            }

            body {
                margin: 0;
                -webkit-print-color-adjust: exact;
                transform: scale(0.99); /* Coba 0.7 atau 0.65 kalau masih kepotong */
                transform-origin: top left;
            }
            table, tr, td, th {
                page-break-inside: avoid !important;
            }

            @page {
                size: A4 portrait;
                margin: 10mm;
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
    </div>

    <div class="grafik">
        <h3>GRAFIK KONSULTASI</h3>
        <br>
        <canvas id="myLineChart" width="700" height="300"></canvas>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        window.chartData = {
            labels: <?php echo json_encode($bulanList); ?>,
            layananList: <?php echo json_encode($layananList); ?>,
            rawData: <?php echo json_encode($chartData); ?>
        };
    </script>
    <script src="{{ asset('js/admin/laporan.js') }}"></script>
    <script>
        setTimeout(() => {
            window.print();
        }, 500);
    </script>
</body>
</html>
