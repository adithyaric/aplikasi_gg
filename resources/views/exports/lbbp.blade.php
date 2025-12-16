<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
</head>

<body>
    <table>
        <tr>
            <td colspan="9" style="text-align: center; font-weight: bold; font-size: 16px;">LAPORAN BIAYA BAHAN PANGAN</td>
        </tr>
        <tr>
            <td colspan="9"></td>
        </tr>
        <tr>
            <td>Nama SPPG :</td>
            <td>{{ $setting->nama_sppg ?? '03 Mandai' }}</td>
            <td colspan="5"></td>
            <td>Periode Awal :</td>
            <td>{{ $startDate ? \Carbon\Carbon::parse($startDate)->format('d/m/Y') : '01/12/2025' }}</td>
        </tr>
        <tr>
            <td>Kelurahan :</td>
            <td>{{ $setting->kelurahan ?? 'Bontoa' }}</td>
            <td colspan="5"></td>
            <td>Periode Akhir :</td>
            <td>{{ $endDate ? \Carbon\Carbon::parse($endDate)->format('d/m/Y') : '12/12/2025' }}</td>
        </tr>
        <tr>
            <td>Kecamatan :</td>
            <td>{{ $setting->kecamatan ?? 'Mandai' }}</td>
            <td colspan="7"></td>
        </tr>
        <tr>
            <td>Kabupaten/Kota :</td>
            <td>{{ $setting->kabupaten ?? 'Maros' }}</td>
            <td colspan="7"></td>
        </tr>
        <tr>
            <td>Provinsi :</td>
            <td>{{ $setting->provinsi ?? 'Sulawesi Selatan' }}</td>
            <td colspan="7"></td>
        </tr>
        <tr>
            <td colspan="9"></td>
        </tr>
        <tr style="text-align: center;">
            <td>No</td>
            <td>Tanggal</td>
            <td>Nama Bahan</td>
            <td colspan="4">Total</td>
            <td>Supplier</td>
            <td>Survei Harga Per Kg/L (Rp)</td>
        </tr>
        <tr style="text-align: center;">
            <td></td>
            <td></td>
            <td></td>
            <td>Kuantitas</td>
            <td>Satuan</td>
            <td>Harga Satuan</td>
            <td>Total</td>
            <td></td>
            <td></td>
        </tr>
        @foreach ($data as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item['tanggal']->format('d/m/Y') }}</td>
                <td>{{ $item['nama_bahan'] }}</td>
                <td>{{ number_format($item['kuantitas'], 0, ',', '.') }}</td>
                <td>{{ $item['satuan'] }}</td>
                <td>{{ number_format($item['harga_satuan'], 0, ',', '.') }}</td>
                <td>{{ number_format($item['total'], 0, ',', '.') }}</td>
                <td>{{ $item['supplier'] }}</td>
                <td>{{ number_format($item['gov_price'], 0, ',', '.') }}</td>
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
            <td colspan="8"></td>
            <td style="text-align: right;">{{ $setting->kabupaten ?? 'Maros' }}, {{ date('d F Y') }}</td>
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
