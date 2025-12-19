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
            <td style="font-weight: bold;">{{ $setting->nama_sppg ?? '03 Mandai' }}</td>
            <td colspan="5"></td>
            <td>Periode Awal :</td>
            <td style="font-weight: bold;">{{ $startDate ? \Carbon\Carbon::parse($startDate)->format('d/m/Y') : '01/12/2025' }}</td>
        </tr>
        <tr>
            <td>Kelurahan :</td>
            <td style="font-weight: bold;">{{ $setting->kelurahan ?? 'Bontoa' }}</td>
            <td colspan="5"></td>
            <td>Periode Akhir :</td>
            <td style="font-weight: bold;">{{ $endDate ? \Carbon\Carbon::parse($endDate)->format('d/m/Y') : '12/12/2025' }}</td>
        </tr>
        <tr>
            <td>Kecamatan :</td>
            <td style="font-weight: bold;">{{ $setting->kecamatan ?? 'Mandai' }}</td>
            <td colspan="7"></td>
        </tr>
        <tr>
            <td>Kabupaten/Kota :</td>
            <td style="font-weight: bold;">{{ $setting->kabupaten ?? 'Maros' }}</td>
            <td colspan="7"></td>
        </tr>
        <tr>
            <td>Provinsi :</td>
            <td style="font-weight: bold;">{{ $setting->provinsi ?? 'Sulawesi Selatan' }}</td>
            <td colspan="7"></td>
        </tr>
        <tr>
            <td colspan="9"></td>
        </tr>
        <tr style="text-align: center; font-weight: bold;">
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">No</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Tanggal</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Nama Bahan</td>
            <td style="font-weight: bold; border: 1px solid #000;" colspan="4">Total</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Supplier</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Survei Harga Per Kg/L (Rp)</td>
        </tr>
        <tr style="text-align: center;">
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;"></td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;"></td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;"></td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Kuantitas</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Satuan</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Harga Satuan</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Total</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;"></td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;"></td>
        </tr>
        @foreach ($data as $index => $item)
            <tr>
                <td style="border: 1px solid #000;">{{ $index + 1 }}</td>
                <td style="border: 1px solid #000;">{{ $item['tanggal']->format('d/m/Y') }}</td>
                <td style="border: 1px solid #000;">{{ $item['nama_bahan'] }}</td>
                <td style="border: 1px solid #000;">{{ $item['kuantitas'] }}</td>
                <td style="border: 1px solid #000;">{{ $item['satuan'] }}</td>
                <td style="border: 1px solid #000;">Rp{{ number_format($item['harga_satuan'], 2, '.', ',') }}</td>
                <td style="border: 1px solid #000;">Rp{{ number_format($item['total'], 2, '.', ',') }}</td>
                <td style="border: 1px solid #000;">{{ $item['supplier'] }}</td>
                <td style="border: 1px solid #000;">Rp{{ number_format($item['gov_price'], 2, '.', ',') }}</td>
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
            <td style="border-bottom: 1px solid #000; font-weight: bold;">{{ $setting->nama_sppi ?? 'Rina Fatma Sari, S.TR.Sos' }}</td>
            <td colspan="7"></td>
            <td style="border-bottom: 1px solid #000; font-weight: bold;">{{ $setting->akuntan_sppg ?? 'Nurul Anniza, S.Ak' }}</td>
        </tr>
    </table>
</body>

</html>
