{{-- resources/views/exports/rekap-porsi.blade.php --}}
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
</head>

<body>
    <table>
        <tr>
            <td colspan="9"></td>
        </tr>
        <tr>
            <td colspan="9" style="text-align: center; font-weight: bold; font-size: 16px;">REKAPITULASI PORSI</td>
        </tr>
        <tr>
            <td colspan="9"></td>
        </tr>
        <tr>
            <td>Nama SPPG :</td>
            <td style="font-weight: bold;">{{ $setting->nama_sppg ?? '03 Mandai' }}</td>
            <td colspan="4"></td>
            <td>Periode Awal :</td>
            <td style="font-weight: bold;">{{ $rekapData[0]['tanggal'] ?? '01/12/2025' }}</td>
        </tr>
        <tr>
            <td>Kelurahan :</td>
            <td style="font-weight: bold;">{{ $setting->kelurahan ?? 'Bontoa' }}</td>
            <td colspan="4"></td>
            <td>Periode Akhir :</td>
            <td style="font-weight: bold;">{{ end($rekapData)['tanggal'] ?? '31/12/2025' }}</td>
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
            <td style="font-weight: bold; border: 1px solid #000; text-align: center;">No</td>
            <td style="font-weight: bold; border: 1px solid #000; text-align: center;">Tanggal</td>
            <td colspan="3" style="font-weight: bold; border: 1px solid #000; text-align: center;">Rencana Porsi</td>
            <td colspan="4" style="font-weight: bold; border: 1px solid #000; text-align: center;">Rencana Anggaran</td>
        </tr>
        <tr style="text-align: center; font-weight: bold;">
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;"></td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;"></td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Total</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Porsi 8K</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Porsi 10K</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Budget 8K</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Budget 10K</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Budget Operasional</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Budget Sewa</td>
        </tr>
        @foreach ($rekapData as $index => $row)
            <tr>
                <td style="border: 1px solid #000;">{{ $index + 1 }}</td>
                <td style="border: 1px solid #000;">{{ $row['tanggal'] }}</td>
                <td style="border: 1px solid #000;">{{ $row['rencana_total'] }}</td>
                <td style="border: 1px solid #000;">{{ $row['rencana_8k'] }}</td>
                <td style="border: 1px solid #000;">{{ $row['rencana_10k'] }}</td>
                <td style="border: 1px solid #000;">Rp{{ number_format($row['budget_8k'], 2, '.', ',') }}</td>
                <td style="border: 1px solid #000;">Rp{{ number_format($row['budget_10k'], 2, '.', ',') }}</td>
                <td style="border: 1px solid #000;">Rp{{ number_format($row['budget_operasional'], 2, '.', ',') }}</td>
                <td style="border: 1px solid #000;">Rp{{ number_format($row['budget_sewa'], 2, '.', ',') }}</td>
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
            <td colspan="9"></td>
        </tr>
        <tr>
            <td colspan="7"></td>
            <td style="text-align: right;">{{ $setting->kabupaten ?? 'Maros' }}, {{ date('d F Y') }}</td>
            <td></td>
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
            <td colspan="6"></td>
            <td style="border-bottom: 1px solid #000; font-weight: bold;">{{ $setting->akuntan_sppg ?? 'Nurul Anniza, S.Ak' }}</td>
        </tr>
    </table>
</body>

</html>
