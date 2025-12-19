<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
</head>

<body>
    <table>
        <tr>
            <td colspan="9" style="text-align: center; font-weight: bold; font-size: 16px;">Laporan Penggunaan Dana Bulanan (LPDB)</td>
        </tr>
        <tr>
            <td colspan="9"></td>
        </tr>
        <tr>
            <td>Nama SPPG :</td>
            <td style="font-weight: bold;">{{ $setting->nama_sppg ?? '03 Mandai' }}</td>
            <td colspan="5"></td>
            <td>Periode :</td>
            <td style="font-weight: bold;">{{ $monthName }}</td>
        </tr>
        <tr>
            <td>Kelurahan :</td>
            <td style="font-weight: bold;">{{ $setting->kelurahan ?? 'Bontoa' }}</td>
            <td colspan="7"></td>
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
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">No</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Tanggal</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Saldo Awal</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Penerimaan Dana</td>
            <td style="font-weight: bold; border: 1px solid #000;" colspan="3">Pengeluaran Dana</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Total</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Saldo Akhir</td>
        </tr>
        <tr style="text-align: center; font-weight: bold;">
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;"></td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;"></td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;"></td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;"></td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Bahan Pangan</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Operasional</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Sewa</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;"></td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;"></td>
        </tr>
        <tr style="text-align: center; font-weight: bold;">
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">(1)</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;"></td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">(2)</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">(3)</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">(4)</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">(5)</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">(6)</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">(7) = (4)+(5)+(6)</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">(8) = (2)+(3)-(7)</td>
        </tr>
        @foreach ($data as $item)
        <tr>
            <td style="border: 1px solid #000;">{{ $item['no'] }}</td>
            <td style="border: 1px solid #000;">{{ $item['tanggal'] }}</td>
            <td style="border: 1px solid #000;">Rp{{ number_format($item['saldo_awal'], 2, '.', ',') }}</td>
            <td style="border: 1px solid #000;">Rp{{ number_format($item['penerimaan_dana'], 2, '.', ',') }}</td>
            <td style="border: 1px solid #000;">Rp{{ number_format($item['bahan_pangan'], 2, '.', ',') }}</td>
            <td style="border: 1px solid #000;">Rp{{ number_format($item['operasional'], 2, '.', ',') }}</td>
            <td style="border: 1px solid #000;">Rp{{ number_format($item['sewa'], 2, '.', ',') }}</td>
            <td style="border: 1px solid #000;">Rp{{ number_format($item['total'], 2, '.', ',') }}</td>
            <td style="border: 1px solid #000;">Rp{{ number_format($item['saldo_akhir'], 2, '.', ',') }}</td>
        </tr>
        @endforeach
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
            <td>Mengetahui</td>
            <td colspan="8"></td>
        </tr>
        <tr>
            <td>Kepala SPPG,</td>
            <td colspan="7"></td>
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
            <td colspan="7"></td>
            <td style="border-bottom: 1px solid #000; font-weight: bold;">{{ $setting->akuntan_sppg ?? 'Nurul Anniza, S.Ak' }}</td>
        </tr>
    </table>
</body>

</html>