<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
</head>

<body>
    <table>
        <tr>
            <td colspan="5" style="text-align: center; font-weight: bold; font-size: 16px;">GAJI KARYAWAN</td>
        </tr>
        <tr>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td>Nama SPPG :</td>
            <td>{{ $setting->nama_sppg ?? '03 Mandai' }}</td>
            <td>Tanggal :</td>
            <td colspan="2">{{ \Carbon\Carbon::parse($tanggal_mulai)->format('d/m/Y') }} -
                {{ \Carbon\Carbon::parse($tanggal_akhir)->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td>Kelurahan :</td>
            <td>{{ $setting->kelurahan ?? 'Bontoa' }}</td>
            <td>Jumlah Hadir :</td>
            <td colspan="2">{{ $totalHadir }} hari</td>
        </tr>
        <tr>
            <td>Kecamatan :</td>
            <td>{{ $setting->kecamatan ?? 'Mandai' }}</td>
            <td>Total Karyawan :</td>
            <td colspan="2">{{ $totalKaryawan }} orang</td>
        </tr>
        <tr>
            <td>Kabupaten/Kota :</td>
            <td>{{ $setting->kabupaten ?? 'Maros' }}</td>
            <td>Total Gaji :</td>
            <td colspan="2">Rp{{ number_format($totalGaji, 0, ',', '.') }},-</td>
        </tr>
        <tr>
            <td>Provinsi :</td>
            <td>{{ $setting->provinsi ?? 'Sulawesi Selatan' }}</td>
            <td colspan="3"></td>
        </tr>
        <tr>
            <td colspan="5"></td>
        </tr>
        <tr style="text-align: center;">
            <td>No</td>
            <td>Nama</td>
            <td>Kategori</td>
            <td>Jumlah Hadir</td>
            <td>Total Gaji</td>
        </tr>
        @foreach ($gajis as $index => $gaji)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $gaji->karyawan->nama ?? '-' }}</td>
                <td>{{ $gaji->karyawan->kategori->nama ?? '-' }}</td>
                <td>{{ $gaji->jumlah_hadir }} hari</td>
                <td>Rp{{ number_format($gaji->total_gaji, 0, ',', '.') }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td colspan="4"></td>
            <td style="text-align: right;">{{ $setting->kabupaten ?? 'Maros' }}, {{ date('d F Y') }}</td>
        </tr>
        <tr>
            <td>Mengetahui</td>
            <td colspan="4"></td>
        </tr>
        <tr>
            <td>Kepala SPPG,</td>
            <td colspan="3"></td>
            <td>Akuntan,</td>
        </tr>
        <tr>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td style="border-top: 1px solid #000;">{{ $setting->nama_sppi ?? 'Rina Fatma Sari, S.TR.Sos' }}</td>
            <td colspan="3"></td>
            <td style="border-top: 1px solid #000;">{{ $setting->akuntan_sppg ?? 'Nurul Anniza, S.Ak' }}</td>
        </tr>
    </table>
</body>

</html>
