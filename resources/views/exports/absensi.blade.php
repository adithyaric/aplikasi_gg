<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
</head>

<body>
    <table>
        <tr>
            <td colspan="4" style="text-align: center; font-weight: bold; font-size: 16px;">ABSENSI</td>
        </tr>
        <tr>
            <td colspan="4"></td>
        </tr>
        <tr>
            <td>Nama SPPG :</td>
            <td style="font-weight: bold;">{{ $setting->nama_sppg ?? '03 Mandai' }}</td>
            <td>Tanggal :</td>
            <td style="font-weight: bold;">{{ \Carbon\Carbon::parse($tanggal)->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td>Kelurahan :</td>
            <td style="font-weight: bold;">{{ $setting->kelurahan ?? 'Bontoa' }}</td>
            <td>Hadir :</td>
            <td style="font-weight: bold;">{{ $hadir }}</td>
        </tr>
        <tr>
            <td>Kecamatan :</td>
            <td style="font-weight: bold;">{{ $setting->kecamatan ?? 'Mandai' }}</td>
            <td>Tidak Hadir :</td>
            <td style="font-weight: bold;">{{ $tidakHadir }}</td>
        </tr>
        <tr>
            <td>Kabupaten/Kota :</td>
            <td style="font-weight: bold;">{{ $setting->kabupaten ?? 'Maros' }}</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td>Provinsi :</td>
            <td style="font-weight: bold;">{{ $setting->provinsi ?? 'Sulawesi Selatan' }}</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td colspan="4"></td>
        </tr>
        <tr style="text-align: center; font-weight: bold;">
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">No</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Nama Karyawan</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Kategori</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Status</td>
        </tr>
        @foreach ($absensis as $index => $absensi)
            <tr>
                <td style="border: 1px solid #000;">{{ $index + 1 }}</td>
                <td style="border: 1px solid #000;">{{ $absensi->karyawan->nama ?? '-' }}</td>
                <td style="border: 1px solid #000;">{{ $absensi->karyawan->kategori->nama ?? '-' }}</td>
                <td style="border: 1px solid #000;">{{ ucfirst($absensi->status) }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="4"></td>
        </tr>
        <tr>
            <td colspan="4"></td>
        </tr>
        <tr>
            <td colspan="4"></td>
        </tr>
        <tr>
            <td colspan="4"></td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td style="text-align: right;">{{ $setting->kabupaten ?? 'Maros' }}, {{ date('d F Y') }}</td>
        </tr>
        <tr>
            <td>Mengetahui</td>
            <td colspan="3"></td>
        </tr>
        <tr>
            <td>Kepala SPPG,</td>
            <td colspan="2"></td>
            <td>Akuntan,</td>
        </tr>
        <tr>
            <td colspan="4"></td>
        </tr>
        <tr>
            <td colspan="4"></td>
        </tr>
        <tr>
            <td colspan="4"></td>
        </tr>
        <tr>
            <td colspan="4"></td>
        </tr>
        <tr>
            <td style="border-bottom: 1px solid #000; font-weight: bold;">{{ $setting->nama_sppi ?? 'Rina Fatma Sari, S.TR.Sos' }}</td>
            <td colspan="2"></td>
            <td style="border-bottom: 1px solid #000; font-weight: bold;">{{ $setting->akuntan_sppg ?? 'Nurul Anniza, S.Ak' }}</td>
        </tr>
    </table>
</body>

</html>
