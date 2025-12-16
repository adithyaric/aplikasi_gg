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
            <td>{{ $setting->nama_sppg ?? '03 Mandai' }}</td>
            <td colspan="5"></td>
            <td>Periode :</td>
            <td>{{ $monthName }}</td>
        </tr>
        <tr>
            <td>Kelurahan :</td>
            <td>{{ $setting->kelurahan ?? 'Bontoa' }}</td>
            <td colspan="7"></td>
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
        <tr style="text-align: center;">
            <td>No</td>
            <td>Tanggal</td>
            <td>Saldo Awal</td>
            <td>Penerimaan Dana</td>
            <td colspan="3">Pengeluaran Dana</td>
            <td>Total</td>
            <td>Saldo Akhir</td>
        </tr>
        <tr style="text-align: center;">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>Bahan Pangan</td>
            <td>Operasional</td>
            <td>Sewa</td>
            <td></td>
            <td></td>
        </tr>
        <tr style="text-align: center;">
            <td>(1)</td>
            <td></td>
            <td>(2)</td>
            <td>(3)</td>
            <td>(4)</td>
            <td>(5)</td>
            <td>(6)</td>
            <td>(7) = (4)+(5)+(6)</td>
            <td>(8) = (2)+(3)-(7)</td>
        </tr>
        @foreach ($data as $item)
        <tr>
            <td>{{ $item['no'] }}</td>
            <td>{{ $item['tanggal'] }}</td>
            <td>Rp{{ number_format($item['saldo_awal'], 0, ',', '.') }}</td>
            <td>Rp{{ number_format($item['penerimaan_dana'], 0, ',', '.') }}</td>
            <td>Rp{{ number_format($item['bahan_pangan'], 0, ',', '.') }}</td>
            <td>Rp{{ number_format($item['operasional'], 0, ',', '.') }}</td>
            <td>Rp{{ number_format($item['sewa'], 0, ',', '.') }}</td>
            <td>Rp{{ number_format($item['total'], 0, ',', '.') }}</td>
            <td>Rp{{ number_format($item['saldo_akhir'], 0, ',', '.') }}</td>
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
            <td style="border-top: 1px solid #000;">{{ $setting->nama_sppi ?? 'Rina Fatma Sari, S.TR.Sos' }}</td>
            <td colspan="7"></td>
            <td style="border-top: 1px solid #000;">{{ $setting->akuntan_sppg ?? 'Nurul Anniza, S.Ak' }}</td>
        </tr>
    </table>
</body>

</html>