<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
</head>

<body>
    <table>
        <tr>
            <td colspan="5" style="text-align: center; font-weight: bold; font-size: 16px;">LAPORAN BIAYA OPERASIONAL</td>
        </tr>
        <tr>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td>Nama SPPG :</td>
            <td>{{ $setting->nama_sppg ?? '03 Mandai' }}</td>
            <td colspan="2"></td>
            <td>Periode Awal :</td>
            <td>{{ $startDate ? \Carbon\Carbon::parse($startDate)->format('d/m/Y') : '01/12/2025' }}</td>
        </tr>
        <tr>
            <td>Kelurahan :</td>
            <td>{{ $setting->kelurahan ?? 'Bontoa' }}</td>
            <td colspan="2"></td>
            <td>Periode Akhir :</td>
            <td>{{ $endDate ? \Carbon\Carbon::parse($endDate)->format('d/m/Y') : '12/12/2025' }}</td>
        </tr>
        <tr>
            <td>Kecamatan :</td>
            <td>{{ $setting->kecamatan ?? 'Mandai' }}</td>
            <td colspan="3"></td>
        </tr>
        <tr>
            <td>Kabupaten/Kota :</td>
            <td>{{ $setting->kabupaten ?? 'Maros' }}</td>
            <td colspan="3"></td>
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
            <td>Tanggal</td>
            <td>Uraian</td>
            <td>Nominal</td>
            <td>Keterangan</td>
        </tr>
        @foreach ($data as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item['tanggal']->format('d/m/Y') }}</td>
                <td>{{ $item['uraian'] }}</td>
                <td>{{ $item['nominal'] }}</td>
                <td>{{ $item['keterangan'] }}</td>
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
            <td style="border-top: 1px solid #000;">{{ $setting->nama_sppi ?? 'Rina Fatma Sari, S.TR.Sos' }}</td>
            <td colspan="3"></td>
            <td style="border-top: 1px solid #000;">{{ $setting->akuntan_sppg ?? 'Nurul Anniza, S.Ak' }}</td>
        </tr>
    </table>
</body>

</html>
