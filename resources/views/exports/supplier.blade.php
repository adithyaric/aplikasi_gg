<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
</head>

<body>
    <table>
        <tr>
            <td colspan="6" style="text-align: center; font-weight: bold; font-size: 16px;">SUPPLIER</td>
        </tr>
        <tr>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td>Nama SPPG :</td>
            <td>{{ $setting->nama_sppg ?? '03 Mandai' }}</td>
            <td colspan="4"></td>
        </tr>
        <tr>
            <td>Kelurahan :</td>
            <td>{{ $setting->kelurahan ?? 'Bontoa' }}</td>
            <td colspan="4"></td>
        </tr>
        <tr>
            <td>Kecamatan :</td>
            <td>{{ $setting->kecamatan ?? 'Mandai' }}</td>
            <td colspan="4"></td>
        </tr>
        <tr>
            <td>Kabupaten/Kota :</td>
            <td>{{ $setting->kabupaten ?? 'Maros' }}</td>
            <td colspan="4"></td>
        </tr>
        <tr>
            <td>Provinsi :</td>
            <td>{{ $setting->provinsi ?? 'Sulawesi Selatan' }}</td>
            <td colspan="4"></td>
        </tr>
        <tr>
            <td colspan="6"></td>
        </tr>
        <tr style="text-align: center;">
            <td>No</td>
            <td>Nama</td>
            <td>No HP</td>
            <td>No Rek</td>
            <td>Nama Bank</td>
            <td>Produk</td>
        </tr>
        @foreach ($suppliers as $index => $supplier)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $supplier->nama }}</td>
                <td>{{ $supplier->no_hp }}</td>
                <td>{{ $supplier->bank_no_rek }}</td>
                <td>{{ $supplier->bank_nama }}</td>
                <td>{{ $supplier->products }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td colspan="5"></td>
            <td style="text-align: right;">{{ $setting->kabupaten ?? 'Maros' }}, {{ date('d F Y') }}</td>
        </tr>
        <tr>
            <td>Mengetahui</td>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td>Kepala SPPG,</td>
            <td colspan="4"></td>
            <td>Akuntan,</td>
        </tr>
        <tr>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td style="border-top: 1px solid #000;">{{ $setting->nama_sppi ?? 'Rina Fatma Sari, S.TR.Sos' }}</td>
            <td colspan="4"></td>
            <td style="border-top: 1px solid #000;">{{ $setting->akuntan_sppg ?? 'Nurul Anniza, S.Ak' }}</td>
        </tr>
    </table>
</body>

</html>
