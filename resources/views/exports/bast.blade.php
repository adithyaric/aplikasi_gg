<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
</head>

<body>
    <table>
        <tr>
            <td colspan="6" style="text-align: center; font-weight: bold; font-size: 16px;">BAST</td>
        </tr>
        <tr>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td>Nama SPPG :</td>
            <td>{{ $setting->nama_sppg ?? '03 Mandai' }}</td>
            <td colspan="2"></td>
            <td>NO PO :</td>
            <td>{{ $order->order_number }}</td>
        </tr>
        <tr>
            <td>Kelurahan :</td>
            <td>{{ $setting->kelurahan ?? 'Bontoa' }}</td>
            <td colspan="2"></td>
            <td>Tanggal Pengiriman :</td>
            <td>{{ $order->tanggal_penerimaan ? \Carbon\Carbon::parse($order->tanggal_penerimaan)->format('d/m/Y') : '-'
                }}</td>
        </tr>
        <tr>
            <td>Kecamatan :</td>
            <td>{{ $setting->kecamatan ?? 'Mandai' }}</td>
            <td colspan="2"></td>
            <td>Tanggal Penerimaan :</td>
            <td>{{ $order->tanggal_penerimaan ? \Carbon\Carbon::parse($order->tanggal_penerimaan)->format('d/m/Y') : '-'
                }}</td>
        </tr>
        <tr>
            <td>Kabupaten/Kota :</td>
            <td>{{ $setting->kabupaten ?? 'Maros' }}</td>
            <td colspan="2"></td>
            <td>Supplier :</td>
            <td>{{ $order->supplier->nama ?? '-' }}</td>
        </tr>
        <tr>
            <td>Provinsi :</td>
            <td>{{ $setting->provinsi ?? 'Sulawesi Selatan' }}</td>
            <td colspan="4"></td>
        </tr>
        <tr>
            <td colspan="6"></td>
        </tr>
        <tr style="text-align: center;">
            <td>No</td>
            <td>Jenis Bahan Pokok</td>
            <td>Satuan</td>
            <td>QTY PO</td>
            <td>QTY Diterima</td>
            <td>Keterangan</td>
        </tr>
        @php
        // Ensure itemsData is a collection
        $itemsData = collect($itemsData);
        @endphp
        @foreach ($itemsData as $index => $item)
        <tr>
            @php
            $item = (object) $item;
            @endphp
            <td>{{ $index + 1 }}</td>
            <td>{{ $item->jenis_bahan ?? '-' }}</td>
            <td>{{ $item->satuan ?? '-' }}</td>
            <td>{{ number_format($item->qty_po ?? 0, 0, ',', '.') }}</td>
            <td>{{ $item->qty_diterima }}</td>
            <td>{{ $item->keterangan ?? '-' }}</td>
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