<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
</head>

<body>
    <table>
        <tr>
            <td colspan="6" style="text-align: center; font-weight: bold; font-size: 16px;">LEMBAR PURCHASE ORDER</td>
        </tr>
        <tr>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td>Nama SPPG :</td>
            <td style="font-weight: bold;">{{ $setting->nama_sppg ?? '03 Mandai' }}</td>
            <td colspan="2"></td>
            <td>NO. PO :</td>
            <td style="font-weight: bold;">{{ $order->order_number }}</td>
        </tr>
        <tr>
            <td>Kelurahan :</td>
            <td style="font-weight: bold;">{{ $setting->kelurahan ?? 'Bontoa' }}</td>
            <td colspan="2"></td>
            <td>Pemasok :</td>
            <td style="font-weight: bold;">{{ $order->supplier->nama ?? '-' }}</td>
        </tr>
        <tr>
            <td>Kecamatan :</td>
            <td style="font-weight: bold;">{{ $setting->kecamatan ?? 'Mandai' }}</td>
            <td colspan="2"></td>
            <td>Tanggal PO :</td>
            <td style="font-weight: bold;">{{ $order->tanggal_po ? \Carbon\Carbon::parse($order->tanggal_po)->format('d/m/Y') : '-' }}</td>
        </tr>
        <tr>
            <td>Kabupaten/Kota :</td>
            <td style="font-weight: bold;">{{ $setting->kabupaten ?? 'Maros' }}</td>
            <td colspan="2"></td>
            <td>Tanggal Pengiriman :</td>
            <td style="font-weight: bold;">{{ $order->tanggal_penerimaan ? \Carbon\Carbon::parse($order->tanggal_penerimaan)->format('d/m/Y') : '-' }}</td>
        </tr>
        <tr>
            <td>Provinsi :</td>
            <td style="font-weight: bold;">{{ $setting->provinsi ?? 'Sulawesi Selatan' }}</td>
            <td colspan="2"></td>
            <td>Total PO :</td>
            <td style="font-weight: bold;">Rp{{ number_format($order->grand_total, 2, '.', ',') }}</td>
        </tr>
        <tr>
            <td colspan="6"></td>
        </tr>
        <tr style="text-align: center; font-weight: bold;">
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">No</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Jenis Bahan Pokok</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Kuantitas</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Satuan</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Harga</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Subtotal</td>
        </tr>
        @foreach ($order->items as $index => $item)
            <tr>
                <td style="border: 1px solid #000;">{{ $index + 1 }}</td>
                <td style="border: 1px solid #000;">
                    {{ $item->bahanBaku->nama ?? $item->bahanOperasional->nama }}
                    @if ($item->bahanBaku && $item->bahanBaku->ukuran)
                        ({{ $item->bahanBaku->ukuran }})
                    @endif
                </td>
                <td style="border: 1px solid #000;">{{ $item->quantity }}</td>
                <td style="border: 1px solid #000;">{{ $item->bahanBaku->satuan ?? ($item->bahanOperasional->satuan ?? $item->satuan) }}</td>
                <td style="border: 1px solid #000;">Rp{{ number_format($item->unit_cost, 2, '.', ',') }}</td>
                <td style="border: 1px solid #000;">Rp{{ number_format($item->subtotal, 2, '.', ',') }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td colspan="5"></td>
            <td style="text-align: right;">{{ $setting->kabupaten ?? 'Maros' }}, {{ date('d F Y') }}</td>
        </tr>
        <tr>
            <td>Mengetahui</td>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td>Kepala SPPG,</td>
            <td colspan="4"></td>
            <td>Akuntan,</td>
        </tr>
        <tr>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td style="border-bottom: 1px solid #000; font-weight: bold;">{{ $setting->nama_sppi ?? 'Rina Fatma Sari, S.TR.Sos' }}</td>
            <td colspan="4"></td>
            <td style="border-bottom: 1px solid #000; font-weight: bold;">{{ $setting->akuntan_sppg ?? 'Nurul Anniza, S.Ak' }}</td>
        </tr>
    </table>
</body>

</html>
