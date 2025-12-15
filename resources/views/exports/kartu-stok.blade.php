<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
</head>

<body>
    <table>
        <tr>
            <td colspan="9" style="text-align: center; font-weight: bold; font-size: 16px;">KARTU STOCK</td>
        </tr>
        <tr>
            <td colspan="9"></td>
        </tr>
        <tr>
            <td>Nama Bahan :</td>
            <td>{{ $bahan->nama }}</td>
            <td colspan="7"></td>
        </tr>
        <tr>
            <td>Kode Akun :</td>
            <td>{{ $bahan->id }}</td>
            <td colspan="7"></td>
        </tr>
        <tr>
            <td>Satuan :</td>
            <td>{{ $bahan->satuan }}</td>
            <td colspan="7"></td>
        </tr>
        <tr>
            <td colspan="9"></td>
        </tr>
        @if ($startDate && $endDate)
            <tr>
                <td>Periode :</td>
                <td>{{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} -
                    {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</td>
                <td colspan="7"></td>
            </tr>
        @endif
        <tr>
            <td colspan="9"></td>
        </tr>
        <tr style="text-align: center;">
            <td>No</td>
            <td>Tanggal</td>
            <td>Stok Awal</td>
            <td>Masuk</td>
            <td>Keluar</td>
            <td>Stok Akhir</td>
            <td>Harga Satuan (Rp)</td>
            <td>Nilai Persediaan</td>
            <td>Keterangan</td>
        </tr>
        @foreach ($kartuData as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($item['tanggal'])->format('d/m/Y') }}</td>
                <td>{{ $item['stok_awal'] }}</td>
                <td>{{ $item['masuk'] }}</td>
                <td>{{ $item['keluar'] }}</td>
                <td>{{ $item['stok_akhir'] }}</td>
                <td>{{ number_format($item['harga'], 0, ',', '.') }}</td>
                <td>{{ number_format($item['nilai'], 0, ',', '.') }}</td>
                <td>{{ $item['keterangan'] }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="9"></td>
        </tr>
        <tr>
            <td colspan="9"></td>
        </tr>
        <tr>
            <td colspan="9"></td>
        </tr>
        <tr>
            <td colspan="9"></td>
        </tr>
        <tr>
            <td colspan="8"></td>
            <td style="text-align: right;">Jakarta, {{ date('d F Y') }}</td>
        </tr>
        <tr>
            <td>Mengetahui</td>
            <td colspan="8"></td>
        </tr>
        <tr>
            <td>Kepala SPPG,</td>
            <td colspan="7"></td>
            <td>Akuntan,</td>
        </tr>
        <tr>
            <td colspan="9"></td>
        </tr>
        <tr>
            <td colspan="9"></td>
        </tr>
        <tr>
            <td colspan="9"></td>
        </tr>
        <tr>
            <td colspan="9"></td>
        </tr>
        <tr>
            <td style="border-top: 1px solid #000;">{{ $setting->nama_sppi ?? 'Rina Fatma Sari, S.TR.Sos' }}</td>
            <td colspan="7"></td>
            <td style="border-top: 1px solid #000;">{{ $setting->akuntan_sppg ?? 'Nurul Anniza, S.Ak' }}</td>
        </tr>
    </table>
</body>

</html>
