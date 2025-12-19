<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
</head>

<body>
    <table>
        <tr>
            <td colspan="8" style="text-align: center; font-weight: bold; font-size: 16px;">STOCK OPNAME</td>
        </tr>
        <tr>
            <td colspan="8"></td>
        </tr>
        <tr>
            <td>Nama SPPG :</td>
            <td style="font-weight: bold;">{{ $setting->nama_sppg ?? '03 Mandai' }}</td>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td>Kelurahan :</td>
            <td style="font-weight: bold;">{{ $setting->kelurahan ?? 'Bontoa' }}</td>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td>Kecamatan :</td>
            <td style="font-weight: bold;">{{ $setting->kecamatan ?? 'Mandai' }}</td>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td>Kabupaten/Kota :</td>
            <td style="font-weight: bold;">{{ $setting->kabupaten ?? 'Maros' }}</td>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td>Provinsi :</td>
            <td style="font-weight: bold;">{{ $setting->provinsi ?? 'Sulawesi Selatan' }}</td>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td colspan="8"></td>
        </tr>
        <tr>
            <td>Tanggal Stok Opname</td>
            <td style="font-weight: bold;">{{ \Carbon\Carbon::parse($adjustmentDate)->format('d/m/Y') }}</td>
            <td colspan="6"></td>
        </tr>
        <tr style="text-align: center; font-weight: bold;">
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">No</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Nama Bahan</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Kode</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Satuan</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Stok Fisik</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Stok di Kartu</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Selisih</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Keterangan</td>
        </tr>
        @foreach ($adjustments as $index => $item)
            <tr>
                <td style="border: 1px solid #000;">{{ $index + 1 }}</td>
                <td style="border: 1px solid #000;">{{ $item['nama'] }}</td>
                <td style="border: 1px solid #000;">{{ $item['kode'] }}</td>
                <td style="border: 1px solid #000;">{{ $item['satuan'] }}</td>
                <td style="border: 1px solid #000;">{{ $item['stok_fisik'] }}</td>
                <td style="border: 1px solid #000;">{{ $item['stok_dikartu'] }}</td>
                <td style="border: 1px solid #000;">{{ $item['selisih'] }}</td>
                <td style="border: 1px solid #000;">{{ $item['keterangan'] }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="8"></td>
        </tr>
        <tr>
            <td colspan="8"></td>
        </tr>
        <tr>
            <td colspan="8"></td>
        </tr>
        <tr>
            <td colspan="8"></td>
        </tr>
        <tr>
            <td colspan="7"></td>
            <td style="text-align: right;">{{ $setting->kabupaten ?? 'Maros' }}, {{ date('d F Y') }}</td>
        </tr>
        <tr>
            <td>Mengetahui</td>
            <td colspan="7"></td>
        </tr>
        <tr>
            <td>Kepala SPPG,</td>
            <td colspan="6"></td>
            <td>Akuntan,</td>
        </tr>
        <tr>
            <td colspan="8"></td>
        </tr>
        <tr>
            <td colspan="8"></td>
        </tr>
        <tr>
            <td colspan="8"></td>
        </tr>
        <tr>
            <td colspan="8"></td>
        </tr>
        <tr>
            <td style="border-bottom: 1px solid #000; font-weight: bold;">{{ $setting->nama_sppi ?? 'Rina Fatma Sari, S.TR.Sos' }}</td>
            <td colspan="6"></td>
            <td style="border-bottom: 1px solid #000; font-weight: bold;">{{ $setting->akuntan_sppg ?? 'Nurul Anniza, S.Ak' }}</td>
        </tr>
    </table>
</body>

</html>
