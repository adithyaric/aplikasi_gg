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
            <td>{{ $setting->nama_sppg ?? '03 Mandai' }}</td>
            <td colspan="4"></td>
            <td>Periode Awal :</td>
            <td>{{ $rekeningKoran->isNotEmpty() ? $rekeningKoran->first()->tanggal_transaksi->format('d/m/Y') : '' }}
            </td>
        </tr>
        <tr>
            <td>Kelurahan :</td>
            <td>{{ $setting->kelurahan ?? 'Bontoa' }}</td>
            <td colspan="4"></td>
            <td>Periode Akhir :</td>
            <td>{{ $rekeningKoran->isNotEmpty() ? $rekeningKoran->last()->tanggal_transaksi->format('d/m/Y') : '' }}
            </td>
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
            <td colspan="10"></td>
        </tr>
        <tr style="text-align: center;">
            <td>No</td>
            <td>Tanggal</td>
            <td>Uraian</td>
            <td>Ref</td>
            <td>Debit</td>
            <td>Kredit</td>
            <td>Saldo</td>
            <td>Kategori Transaksi</td>
            <td>Minggu</td>
            <td>Link PO</td>
        </tr>
        @foreach ($rekeningKoran as $index => $item)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $item->tanggal_transaksi->format('d/m/Y H:i') }}</td>
            <td>{{ $item->uraian }}</td>
            <td>{{ $item->ref }}</td>
            <td>
                @if ($item->debit > 0)
                Rp{{ number_format($item->debit, 0, ',', '.') }}
                @endif
            </td>
            <td>
                @if ($item->kredit > 0)
                Rp{{ number_format($item->kredit, 0, ',', '.') }}
                @endif
            </td>
            <td>Rp{{ number_format($item->saldo, 0, ',', '.') }}</td>
            <td>{{ $item->kategori_transaksi }}</td>
            <td>{{ $item->minggu ? 'Minggu ' . $item->minggu : '-' }}</td>
            <td>{{ $item->transaction && $item->transaction->order ? $item->transaction->order->order_number : '-' }}
            </td>
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
            <td colspan="8"></td>
            <td colspan="2" style="text-align: right;">{{ $setting->kabupaten ?? 'Maros' }}, {{ date('d F Y') }}</td>
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
            <td style="border-top: 1px solid #000;">{{ $setting->nama_sppi ?? 'Rina Fatma Sari, S.TR.Sos' }}</td>
            <td colspan="7"></td>
            <td style="border-top: 1px solid #000;">{{ $setting->akuntan_sppg ?? 'Nurul Anniza, S.Ak' }}</td>
        </tr>
    </table>
</body>

</html>