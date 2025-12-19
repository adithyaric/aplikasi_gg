<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
</head>

<body>
    <table>
        <tr>
            <td colspan="8" style="text-align: center; font-weight: bold; font-size: 16px;">STOCK</td>
        </tr>
        <tr>
            <td colspan="8"></td>
        </tr>
        <tr>
            <td>Nama SPPG :</td>
            <td style="font-weight: bold;">{{ $setting->nama_sppg ?? '03 Mandai' }}</td>
            <td colspan="4"></td>
            <td>Tanggal :</td>
            <td style="font-weight: bold;">{{ date('d/m/Y') }}</td>
        </tr>
        <tr>
            <td>Kelurahan :</td>
            <td style="font-weight: bold;">{{ $setting->kelurahan ?? 'Bontoa' }}</td>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td>Kecamatan :</td>
            <td style="font-weight: bold;">{{ $setting->kecamatan ?? 'Mandai' }}</td>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td>Kabupaten/Kota :</td>
            <td style="font-weight: bold;">{{ $setting->kabupaten ?? 'Maros' }}</td>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td>Provinsi :</td>
            <td style="font-weight: bold;">{{ $setting->provinsi ?? 'Sulawesi Selatan' }}</td>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td colspan="8"></td>
        </tr>
        <tr style="text-align: center; font-weight: bold;">
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">No</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Nama Barang</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Kategori</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Brand</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Qty</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">L. Pembelian</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Avg. Cost</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Gov. Price</td>
        </tr>
        @foreach ($stok as $index => $item)
            <tr>
                <td style="border: 1px solid #000;">{{ $index + 1 }}</td>
                <td style="border: 1px solid #000;">{{ $item->nama }} ({{ $item->satuan }})</td>
                <td style="border: 1px solid #000;">{{ $item->kategori }}</td>
                <td style="border: 1px solid #000;">{{ $item->merek }}</td>
                <td style="border: 1px solid #000;">{{ $item->qty }}</td>
                <td style="border: 1px solid #000;">
                    @if ($item->qty > 0 && $item->last_purchase_price > 0)
                        Rp{{ number_format($item->last_purchase_price, 2, '.', ',') }}
                    @else
                        -
                    @endif
                </td>
                <td style="border: 1px solid #000;">
                    @if ($item->qty > 0 && $item->avg_cost > 0)
                        Rp{{ number_format($item->avg_cost, 2, '.', ',') }}
                    @else
                        -
                    @endif
                </td>
                <td style="border: 1px solid #000;">Rp{{ number_format($item->gov_price, 2, '.', ',') }}</td>
            </tr>
        @endforeach
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
            <td style="border-bottom: 1px solid #000; font-weight: bold;">{{ $setting->nama_sppi ?? 'Rina Fatma Sari, S.TR.Sos' }}</td>
            <td colspan="6"></td>
            <td style="border-bottom: 1px solid #000; font-weight: bold;">{{ $setting->akuntan_sppg ?? 'Nurul Anniza, S.Ak' }}</td>
        </tr>
    </table>
</body>

</html>
