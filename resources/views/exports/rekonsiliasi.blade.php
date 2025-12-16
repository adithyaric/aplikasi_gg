<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
</head>

<body>
    <table>
        <tr>
            <td colspan="8" style="text-align: center; font-weight: bold; font-size: 16px;">REKONSILIASI</td>
        </tr>
        <tr>
            <td colspan="8"></td>
        </tr>
        <tr>
            <td>Nama SPPG :</td>
            <td>{{ $setting->nama_sppg ?? '03 Mandai' }}</td>
            <td colspan="4"></td>
            <td>Periode Awal :</td>
            <td>{{ $startDate ? \Carbon\Carbon::parse($startDate)->format('d/m/Y') : '01/12/2025' }}</td>
        </tr>
        <tr>
            <td>Kelurahan :</td>
            <td>{{ $setting->kelurahan ?? 'Bontoa' }}</td>
            <td colspan="4"></td>
            <td>Periode Akhir :</td>
            <td>{{ $endDate ? \Carbon\Carbon::parse($endDate)->format('d/m/Y') : '15/12/2025' }}</td>
        </tr>
        <tr>
            <td>Kecamatan :</td>
            <td>{{ $setting->kecamatan ?? 'Mandai' }}</td>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td>Kabupaten/Kota :</td>
            <td>{{ $setting->kabupaten ?? 'Maros' }}</td>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td>Provinsi :</td>
            <td>{{ $setting->provinsi ?? 'Sulawesi Selatan' }}</td>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td colspan="8"></td>
        </tr>
        <tr style="text-align: center;">
            <td>No</td>
            <td>Tanggal</td>
            <td>Rekening Koran</td>
            <td></td>
            <td>Detail BKU</td>
            <td></td>
            <td>Selisih</td>
            <td>Status</td>
        </tr>
        <tr style="text-align: center;">
            <td></td>
            <td></td>
            <td>Jumlah Transaksi</td>
            <td>Nilai Transaksi</td>
            <td>Jumlah Transaksi</td>
            <td>Nilai Transaksi</td>
            <td></td>
            <td></td>
        </tr>
        @foreach ($reconciliationData as $item)
            <tr>
                <td>{{ $item['no'] }}</td>
                <td>{{ $item['tanggal']->translatedFormat('j F Y') }}</td>
                <td>{{ $item['jml_rek'] }}</td>
                <td>Rp{{ number_format($item['nilai_rek'], 0, ',', '.') }}</td>
                <td>{{ $item['jml_buku'] }}</td>
                <td>Rp{{ number_format($item['nilai_buku'], 0, ',', '.') }}</td>
                <td>Rp{{ number_format($item['selisih'], 0, ',', '.') }}</td>
                <td>{{ $item['status'] }}</td>
            </tr>
        @endforeach
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
            <td style="border-top: 1px solid #000;">{{ $setting->nama_sppi ?? 'Rina Fatma Sari, S.TR.Sos' }}</td>
            <td colspan="6"></td>
            <td style="border-top: 1px solid #000;">{{ $setting->akuntan_sppg ?? 'Nurul Anniza, S.Ak' }}</td>
        </tr>
    </table>
</body>

</html>
