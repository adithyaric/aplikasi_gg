<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
</head>

<body>
    <table>
        <tr>
            <td colspan="10" style="text-align: center; font-weight: bold; font-size: 16px;">Rekening Koran VA</td>
        </tr>
        <tr>
            <td colspan="10"></td>
        </tr>
        <tr>
            <td>Nama SPPG :</td>
            <td style="font-weight: bold;">{{ $setting->nama_sppg ?? '03 Mandai' }}</td>
            <td colspan="4"></td>
            <td>Periode Awal :</td>
            <td style="font-weight: bold;">{{ $rekeningKoran->isNotEmpty() ? $rekeningKoran->first()->tanggal_transaksi->format('d/m/Y') : '' }}</td>
        </tr>
        <tr>
            <td>Kelurahan :</td>
            <td style="font-weight: bold;">{{ $setting->kelurahan ?? 'Bontoa' }}</td>
            <td colspan="4"></td>
            <td>Periode Akhir :</td>
            <td style="font-weight: bold;">{{ $rekeningKoran->isNotEmpty() ? $rekeningKoran->last()->tanggal_transaksi->format('d/m/Y') : '' }}</td>
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
            <td colspan="10"></td>
        </tr>
        <tr style="text-align: center; font-weight: bold;">
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">No</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Tanggal</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Uraian</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Ref</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Debit</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Kredit</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Saldo</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Kategori Transaksi</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Minggu</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Link PO</td>
        </tr>
        @foreach ($rekeningKoran as $index => $item)
        <tr>
            <td style="border: 1px solid #000;">{{ $index + 1 }}</td>
            <td style="border: 1px solid #000;">{{ $item->tanggal_transaksi->format('d/m/Y H:i') }}</td>
            <td style="border: 1px solid #000;">{{ $item->uraian }}</td>
            <td style="border: 1px solid #000;">{{ $item->ref }}</td>
            <td style="border: 1px solid #000;">
                @if ($item->debit > 0)
                Rp{{ number_format($item->debit, 2, '.', ',') }}
                @endif
            </td>
            <td style="border: 1px solid #000;">
                @if ($item->kredit > 0)
                Rp{{ number_format($item->kredit, 2, '.', ',') }}
                @endif
            </td>
            <td style="border: 1px solid #000;">Rp{{ number_format($item->saldo, 2, '.', ',') }}</td>
            <td style="border: 1px solid #000;">{{ $item->kategori_transaksi }}</td>
            <td style="border: 1px solid #000;">{{ $item->minggu ? 'Minggu ' . $item->minggu : '-' }}</td>
            <td style="border: 1px solid #000;">{{ $item->transaction && $item->transaction->order ? $item->transaction->order->order_number : '-' }}</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="10"></td>
        </tr>
        <tr>
            <td colspan="10"></td>
        </tr>
        <tr>
            <td colspan="10"></td>
        </tr>
        <tr>
            <td colspan="6"></td>
            <td colspan="2" style="text-align: right;">{{ $setting->kabupaten ?? 'Maros' }}, {{ date('d F Y') }}</td>
        </tr>
        <tr>
            <td>Mengetahui</td>
            <td colspan="8"></td>
        </tr>
        <tr>
            <td>Kepala SPPG,</td>
            <td colspan="6"></td>
            <td>Akuntan,</td>
        </tr>
        <tr>
            <td colspan="10"></td>
        </tr>
        <tr>
            <td colspan="10"></td>
        </tr>
        <tr>
            <td colspan="10"></td>
        </tr>
        <tr>
            <td colspan="10"></td>
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