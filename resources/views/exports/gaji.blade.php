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
            <td style="font-weight: bold;">{{ $setting->nama_sppg ?? '03 Mandai' }}</td>
            <td>Tanggal :</td>
            <td style="font-weight: bold;" colspan="2">{{ \Carbon\Carbon::parse($tanggal_mulai)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($tanggal_akhir)->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td>Kelurahan :</td>
            <td style="font-weight: bold;">{{ $setting->kelurahan ?? 'Bontoa' }}</td>
            <td>Jumlah Hadir :</td>
            <td style="font-weight: bold;" colspan="2">{{ $totalHadir }} hari</td>
        </tr>
        <tr>
            <td>Kecamatan :</td>
            <td style="font-weight: bold;">{{ $setting->kecamatan ?? 'Mandai' }}</td>
            <td>Total Karyawan :</td>
            <td style="font-weight: bold;" colspan="2">{{ $totalKaryawan }} orang</td>
        </tr>
        <tr>
            <td>Kabupaten/Kota :</td>
            <td style="font-weight: bold;">{{ $setting->kabupaten ?? 'Maros' }}</td>
            <td>Total Gaji :</td>
            <td style="font-weight: bold;" colspan="2">Rp{{ number_format($totalGaji, 2, '.', ',') }},-</td>
        </tr>
        <tr>
            <td>Provinsi :</td>
            <td style="font-weight: bold;">{{ $setting->provinsi ?? 'Sulawesi Selatan' }}</td>
            <td colspan="3"></td>
        </tr>
        <tr>
            <td colspan="5"></td>
        </tr>
        <tr style="text-align: center; font-weight: bold;">
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">No</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Nama</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Kategori</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Jumlah Hadir</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Total Gaji</td>
        </tr>
        @foreach ($gajis as $index => $gaji)
            <tr>
                <td style="border: 1px solid #000;">{{ $index + 1 }}</td>
                <td style="border: 1px solid #000;">{{ $gaji->karyawan->nama ?? '-' }}</td>
                <td style="border: 1px solid #000;">{{ $gaji->karyawan->kategori->nama ?? '-' }}</td>
                <td style="border: 1px solid #000;">{{ $gaji->jumlah_hadir }} hari</td>
                <td style="border: 1px solid #000;">Rp{{ number_format($gaji->total_gaji, 2, '.', ',') }}</td>
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
            <td style="border-bottom: 1px solid #000; font-weight: bold;">{{ $setting->nama_sppi ?? 'Rina Fatma Sari, S.TR.Sos' }}</td>
            <td colspan="3"></td>
            <td style="border-bottom: 1px solid #000; font-weight: bold;">{{ $setting->akuntan_sppg ?? 'Nurul Anniza, S.Ak' }}</td>
        </tr>
    </table>
</body>

</html>
