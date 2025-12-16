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
            <td>{{ $setting->nama_sppg ?? '03 Mandai' }}</td>
            <td colspan="4"></td>
            <td>Tanggal :</td>
            <td>{{ date('d/m/Y') }}</td>
        </tr>
        <tr>
            <td>Kelurahan :</td>
            <td>{{ $setting->kelurahan ?? 'Bontoa' }}</td>
            <td colspan="6"></td>
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
            <td>Nama Barang</td>
            <td>Kategori</td>
            <td>Brand</td>
            <td>Qty</td>
            <td>L. Pembelian</td>
            <td>Avg. Cost</td>
            <td>Gov. Price</td>
        </tr>
        @foreach ($stok as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->nama }} ({{ $item->satuan }})</td>
                <td>{{ $item->kategori }}</td>
                <td>{{ $item->merek }}</td>
                <td>{{ $item->qty }}</td>
                <td>
                    @if ($item->qty > 0 && $item->last_purchase_price > 0)
                        Rp{{ number_format($item->last_purchase_price, 0, ',', '.') }}
                    @else
                        -
                    @endif
                </td>
                <td>
                    @if ($item->qty > 0 && $item->avg_cost > 0)
                        Rp{{ number_format($item->avg_cost, 0, ',', '.') }}
                    @else
                        -
                    @endif
                </td>
                <td>Rp{{ number_format($item->gov_price, 0, ',', '.') }}</td>
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
            <td style="border-top: 1px solid #000;">{{ $setting->nama_sppi ?? 'Rina Fatma Sari, S.TR.Sos' }}</td>
            <td colspan="6"></td>
            <td style="border-top: 1px solid #000;">{{ $setting->akuntan_sppg ?? 'Nurul Anniza, S.Ak' }}</td>
        </tr>
    </table>
</body>

</html>
