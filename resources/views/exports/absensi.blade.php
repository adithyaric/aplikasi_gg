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
            <td>{{ $setting->nama_sppg ?? '03 Mandai' }}</td>
            <td>Tanggal :</td>
            <td>{{ \Carbon\Carbon::parse($tanggal)->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td>Kelurahan :</td>
            <td>{{ $setting->kelurahan ?? 'Bontoa' }}</td>
            <td>Hadir :</td>
            <td>{{ $hadir }}</td>
        </tr>
        <tr>
            <td>Kecamatan :</td>
            <td>{{ $setting->kecamatan ?? 'Mandai' }}</td>
            <td>Tidak Hadir :</td>
            <td>{{ $tidakHadir }}</td>
        </tr>
        <tr>
            <td>Kabupaten/Kota :</td>
            <td>{{ $setting->kabupaten ?? 'Maros' }}</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td>Provinsi :</td>
            <td>{{ $setting->provinsi ?? 'Sulawesi Selatan' }}</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td colspan="4"></td>
        </tr>
        <tr style="text-align: center;">
            <td>No</td>
            <td>Nama Karyawan</td>
            <td>Kategori</td>
            <td>Status</td>
        </tr>
        @foreach ($absensis as $index => $absensi)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $absensi->karyawan->nama ?? '-' }}</td>
                <td>{{ $absensi->karyawan->kategori->nama ?? '-' }}</td>
                <td>{{ ucfirst($absensi->status) }}</td>
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
            <td style="text-align: right;">Jakarta, {{ date('d F Y') }}</td>
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
            <td style="border-top: 1px solid #000;">{{ $setting->nama_sppi ?? 'Rina Fatma Sari, S.TR.Sos' }}</td>
            <td colspan="2"></td>
            <td style="border-top: 1px solid #000;">{{ $setting->akuntan_sppg ?? 'Nurul Anniza, S.Ak' }}</td>
        </tr>
    </table>
</body>

</html>
