@extends('layouts.admin.admin') {{-- Pastikan 'layouts.admin' sesuai dengan path dan nama file layout utama Anda --}}

@section('title', 'Laporan') {{-- Mengatur judul untuk halaman ini --}}

@section('content')
        <div class="head-title">
            <div class="left">
                <h1>LAPORAN</h1>
                <ul class="breadcrumb">
                    <li>
                        <a href="#">LAPORAN</a>
                    </li>
                    <li><i class='bx bx-chevron-right' ></i></li>
                    <li>
                        <a class="active" href="#">Grafik Analisis</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="table-data">
            <div class="grafik">
                <div class="head">
                    <h3>GRAFIK ANALISIS</h3>
                    <i class='bx bx-filter'></i>
                    <div class="boxFilter">
                        <form action="{{ route('admin.laporan') }}" method="GET">
                            <select id="tahun" onchange="this.form.submit()" name="tahun" style="width: 100%; padding: 5px; border: 1px solid; border-radius: 5px; font-size: 12px;">
                            <option value="">-- Pilih Tahun --</option>
                            @foreach($availableYears as $yearOption)
                            <option value="{{ $yearOption }}" {{ $yearOption == $tahun ? 'selected' : '' }}>{{ $yearOption }}</option>
                            @endforeach
                            </select>
                        </form>
                    </div>
                </div>
                <canvas id="myLineChart" width="400" height="200"></canvas>
                <a class="btn btn-outline-primary" href="{{ route('admin.laporan.cetak', ['tahun' => $tahun]) }}" target="_blank" role="button" style="float:right; font-size:15px">Cetak Laporan</a>
            </div>
        </div>
@endsection

@section('scripts')
    <script>
        window.chartData = {
            labels: <?php echo json_encode($bulanList); ?>,
            layananList: <?php echo json_encode($layananList); ?>,
            rawData: <?php echo json_encode($data); ?>
        };
    </script>
    <script src="{{ asset('js/admin/laporan.js') }}"></script>
@endsection