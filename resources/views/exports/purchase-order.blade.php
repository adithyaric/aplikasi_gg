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
            <td>{{ $setting->nama_sppg ?? '03 Mandai' }}</td>
            <td colspan="2"></td>
            <td>NO. PO :</td>
            <td>{{ $order->order_number }}</td>
        </tr>
        <tr>
            <td>Kelurahan :</td>
            <td>{{ $setting->kelurahan ?? 'Bontoa' }}</td>
            <td colspan="2"></td>
            <td>Pemasok :</td>
            <td>{{ $order->supplier->nama ?? '-' }}</td>
        </tr>
        <tr>
            <td>Kecamatan :</td>
            <td>{{ $setting->kecamatan ?? 'Mandai' }}</td>
            <td colspan="2"></td>
            <td>Tanggal PO :</td>
            <td>{{ $order->tanggal_po ? \Carbon\Carbon::parse($order->tanggal_po)->format('d/m/Y') : '-' }}</td>
        </tr>
        <tr>
            <td>Kabupaten/Kota :</td>
            <td>{{ $setting->kabupaten ?? 'Maros' }}</td>
            <td colspan="2"></td>
            <td>Tanggal Pengiriman :</td>
            <td>{{ $order->tanggal_penerimaan ? \Carbon\Carbon::parse($order->tanggal_penerimaan)->format('d/m/Y') : '-' }}
            </td>
        </tr>
        <tr>
            <td>Provinsi :</td>
            <td>{{ $setting->provinsi ?? 'Sulawesi Selatan' }}</td>
            <td colspan="2"></td>
            <td>Total PO :</td>
            <td>Rp{{ number_format($order->grand_total, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td colspan="6"></td>
        </tr>
        <tr style="text-align: center;">
            <td>No</td>
            <td>Jenis Bahan Pokok</td>
            <td>Kuantitas</td>
            <td>Satuan</td>
            <td>Harga</td>
            <td>Subtotal</td>
        </tr>
        @foreach ($order->items as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                    {{ $item->bahanBaku->nama ?? $item->bahanOperasional->nama }}
                    @if ($item->bahanBaku && $item->bahanBaku->ukuran)
                        ({{ $item->bahanBaku->ukuran }})
                    @endif
                </td>
                <td>{{ number_format($item->quantity, 0, ',', '.') }}</td>
                <td>{{ $item->bahanBaku->satuan ?? ($item->bahanOperasional->satuan ?? $item->satuan) }}</td>
                <td>Rp{{ number_format($item->unit_cost, 0, ',', '.') }}</td>
                <td>Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
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
            <td style="border-top: 1px solid #000;">{{ $setting->nama_sppi ?? 'Rina Fatma Sari, S.TR.Sos' }}</td>
            <td colspan="4"></td>
            <td style="border-top: 1px solid #000;">{{ $setting->akuntan_sppg ?? 'Nurul Anniza, S.Ak' }}</td>
        </tr>
    </table>
</body>

</html>
