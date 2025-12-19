<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
</head>

<body>
    <table>
        <tr>
            <td colspan="7" style="text-align: center; font-weight: bold; font-size: 16px;">SEKOLAH</td>
        </tr>
        <tr>
            <td colspan="7"></td>
        </tr>
        <tr>
            <td>Nama SPPG :</td>
            <td style="font-weight: bold;">{{ $setting->nama_sppg ?? '03 Mandai' }}</td>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td>Kelurahan :</td>
            <td style="font-weight: bold;">{{ $setting->kelurahan ?? 'Bontoa' }}</td>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td>Kecamatan :</td>
            <td style="font-weight: bold;">{{ $setting->kecamatan ?? 'Mandai' }}</td>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td>Kabupaten/Kota :</td>
            <td style="font-weight: bold;">{{ $setting->kabupaten ?? 'Maros' }}</td>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td>Provinsi :</td>
            <td style="font-weight: bold;">{{ $setting->provinsi ?? 'Sulawesi Selatan' }}</td>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td colspan="7"></td>
        </tr>
        <tr style="text-align: center; font-weight: bold;">
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">No</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Nama</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Nama PIC</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Nomor</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Jarak (KM)</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Porsi 8K</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Porsi 10K</td>
        </tr>
        @foreach ($sekolahs as $index => $sekolah)
            <tr>
                <td style="border: 1px solid #000;">{{ $index + 1 }}</td>
                <td style="border: 1px solid #000;">{{ $sekolah->nama }}</td>
                <td style="border: 1px solid #000;">{{ $sekolah->nama_pic }}</td>
                <td style="border: 1px solid #000;">{{ $sekolah->nomor }}</td>
                <td style="border: 1px solid #000;">{{ $sekolah->jarak }}</td>
                <td style="border: 1px solid #000;">{{ $sekolah->porsi_8k }}</td>
                <td style="border: 1px solid #000;">{{ $sekolah->porsi_10k }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="7"></td>
        </tr>
        <tr>
            <td colspan="7"></td>
        </tr>
        <tr>
            <td colspan="7"></td>
        </tr>
        <tr>
            <td colspan="7"></td>
        </tr>
        <tr>
            <td colspan="6"></td>
            <td style="text-align: right;">{{ $setting->kabupaten ?? 'Maros' }}, {{ date('d F Y') }}</td>
        </tr>
        <tr>
            <td>Mengetahui</td>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td>Kepala SPPG,</td>
            <td colspan="5"></td>
            <td>Akuntan,</td>
        </tr>
        <tr>
            <td colspan="7"></td>
        </tr>
        <tr>
            <td colspan="7"></td>
        </tr>
        <tr>
            <td colspan="7"></td>
        </tr>
        <tr>
            <td colspan="7"></td>
        </tr>
        <tr>
            <td style="border-bottom: 1px solid #000; font-weight: bold;">{{ $setting->nama_sppi ?? 'Rina Fatma Sari, S.TR.Sos' }}</td>
            <td colspan="5"></td>
            <td style="border-bottom: 1px solid #000; font-weight: bold;">{{ $setting->akuntan_sppg ?? 'Nurul Anniza, S.Ak' }}</td>
        </tr>
    </table>
</body>

</html>
