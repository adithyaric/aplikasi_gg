<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
</head>

<body>
    <table>
        <tr>
            <td colspan="9" style="text-align: center; font-weight: bold; font-size: 16px;">KARTU STOCK</td>
        </tr>
        <tr>
            <td colspan="9"></td>
        </tr>
        <tr>
            <td>Nama Bahan :</td>
            <td style="font-weight: bold;">{{ $bahan->nama }}</td>
            <td colspan="7"></td>
        </tr>
        <tr>
            <td>Kode Akun :</td>
            <td style="font-weight: bold;">{{ $bahan->id }}</td>
            <td colspan="7"></td>
        </tr>
        <tr>
            <td>Satuan :</td>
            <td style="font-weight: bold;">{{ $bahan->satuan }}</td>
            <td colspan="7"></td>
        </tr>
        <tr>
            <td colspan="9"></td>
        </tr>
        @if ($startDate && $endDate)
            <tr>
                <td>Periode :</td>
                <td style="font-weight: bold;">{{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} -
                    {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</td>
                <td colspan="7"></td>
            </tr>
        @endif
        <tr>
            <td colspan="9"></td>
        </tr>
        <tr style="text-align: center; font-weight: bold;">
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">No</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Tanggal</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Stok Awal</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Masuk</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Keluar</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Stok Akhir</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Harga Satuan (Rp)</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Nilai Persediaan</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Keterangan</td>
        </tr>
        @foreach ($kartuData as $index => $item)
            <tr>
                <td style="border: 1px solid #000;">{{ $index + 1 }}</td>
                <td style="border: 1px solid #000;">{{ \Carbon\Carbon::parse($item['tanggal'])->format('d/m/Y') }}</td>
                <td style="border: 1px solid #000;">{{ $item['stok_awal'] }}</td>
                <td style="border: 1px solid #000;">{{ $item['masuk'] }}</td>
                <td style="border: 1px solid #000;">{{ $item['keluar'] }}</td>
                <td style="border: 1px solid #000;">{{ $item['stok_akhir'] }}</td>
                <td style="border: 1px solid #000;">Rp{{ number_format($item['harga'], 2, '.', ',') }}</td>
                <td style="border: 1px solid #000;">Rp{{ number_format($item['nilai'], 2, '.', ',') }}</td>
                <td style="border: 1px solid #000;">{{ $item['keterangan'] }}</td>
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
            <td colspan="8"></td>
        </tr>
        <tr>
            <td>Kepala SPPG,</td>
            <td colspan="6"></td>
            <td>Akuntan,</td>
            <td></td>
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
            <td></td>
        </tr>
    </table>
</body>

</html>
