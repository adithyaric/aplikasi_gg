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
            <td>{{ $setting->nama_sppg ?? '03 Mandai' }}</td>
            <td colspan="4"></td>
            <td>Periode Awal :</td>
            <td>{{ $rekapData[0]['tanggal'] ?? '01/12/2025' }}</td>
        </tr>
        <tr>
            <td>Kelurahan :</td>
            <td>{{ $setting->kelurahan ?? 'Bontoa' }}</td>
            <td colspan="4"></td>
            <td>Periode Akhir :</td>
            <td>{{ end($rekapData)['tanggal'] ?? '31/12/2025' }}</td>
        </tr>
        <tr>
            <td>Kecamatan :</td>
            <td>{{ $setting->kecamatan ?? 'Mandai' }}</td>
            <td colspan="7"></td>
        </tr>
        <tr>
            <td>Kabupaten/Kota :</td>
            <td>{{ $setting->kabupaten ?? 'Maros' }}</td>
            <td colspan="7"></td>
        </tr>
        <tr>
            <td>Provinsi :</td>
            <td>{{ $setting->provinsi ?? 'Sulawesi Selatan' }}</td>
            <td colspan="7"></td>
        </tr>
        <tr>
            <td colspan="9"></td>
        </tr>
        <tr style=" text-align: center;">
            <td>No</td>
            <td>Tanggal</td>
            <td colspan="3">Rencana Porsi</td>
            <td colspan="4">Rencana Anggaran</td>
        </tr>
        <tr style=" text-align: center;">
            <td></td>
            <td></td>
            <td>Total</td>
            <td>Porsi 8K</td>
            <td>Porsi 10K</td>
            <td>Budget 8K</td>
            <td>Budget 10K</td>
            <td>Budget Operasional</td>
            <td>Budget Sewa</td>
        </tr>
        @foreach ($rekapData as $index => $row)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $row['tanggal'] }}</td>
                <td>{{ $row['rencana_total'] }}</td>
                <td>{{ $row['rencana_8k'] }}</td>
                <td>{{ $row['rencana_10k'] }}</td>
                <td>Rp{{ number_format($row['budget_8k'], 0, ',', '.') }}</td>
                <td>Rp{{ number_format($row['budget_10k'], 0, ',', '.') }}</td>
                <td>Rp{{ number_format($row['budget_operasional'], 0, ',', '.') }}</td>
                <td>Rp{{ number_format($row['budget_sewa'], 0, ',', '.') }}</td>
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
            <td colspan="8"></td>
            <td style="text-align: right;">{{ $setting->kabupaten ?? 'Maros' }}, {{ date('d F Y') }}</td>
        </tr>
        <tr>
            <td style="">Mengetahui</td>
            <td colspan="7"></td>
        </tr>
        <tr>
            <td style="">Kepala SPPG,</td>
            <td colspan="6"></td>
            <td style="">Akuntan,</td>
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
            <td style=" border-top: 1px solid #000;">{{ $setting->nama_sppi ?? 'Rina Fatma Sari, S.TR.Sos' }}</td>
            <td colspan="6"></td>
            <td style=" border-top: 1px solid #000;">{{ $setting->akuntan_sppg ?? 'Nurul Anniza, S.Ak' }}</td>
        </tr>
    </table>
</body>

</html>
