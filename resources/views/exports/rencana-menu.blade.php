<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
</head>

<body>
    <table>
        <tr>
            <td colspan="8" style="text-align: center; font-weight: bold; font-size: 16px;">REKAP MENU</td>
        </tr>
        <tr>
            <td colspan="8"></td>
        </tr>
        <tr>
            <td>Nama SPPG :</td>
            <td style="font-weight: bold;">{{ $setting->nama_sppg ?? '03 Mandai' }}</td>
            <td colspan="3"></td>
            <td>Periode :</td>
            <td style="font-weight: bold;">
                @if ($startDate && $endDate)
                    {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} -
                    {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}
                @else
                    {{ date('d/m/Y') }}
                @endif
            </td>
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
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Paket Menu</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Nama Menu</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Bahan Makanan</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Berat Per Porsi</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Jumlah Porsi</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Total Kebutuhan</td>
        </tr>
        @php
            $previousTanggal = null;
            $previousPaket = null;
            $previousMenu = null;
        @endphp
        @foreach ($exportData as $item)
            <tr>
                <td style="border: 1px solid #000;">{{ $item['no'] }}</td>
                <td style="border: 1px solid #000;">{{ $item['paket_menu'] }}</td>
                <td style="border: 1px solid #000;">{{ $item['nama_menu'] }}</td>
                <td style="border: 1px solid #000;">{{ $item['bahan_makanan'] }}</td>
                <td style="border: 1px solid #000;">{{ $item['berat_per_porsi'] }}</td>
                <td style="border: 1px solid #000;">{{ $item['jumlah_porsi'] }}</td>
                <td style="border: 1px solid #000;">{{ $item['total_kebutuhan'] }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="8"></td>
        </tr>
        <tr>
            <td colspan="8"></td>
        </tr>
        <tr>
            <td colspan="5"></td>
            <td style="text-align: right;">{{ $setting->kabupaten ?? 'Maros' }}, {{ date('d F Y') }}</td>
        </tr>
        <tr>
            <td>Mengetahui</td>
            <td colspan="7"></td>
        </tr>
        <tr>
            <td>Kepala SPPG,</td>
            <td colspan="4"></td>
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
            <td colspan="4"></td>
            <td style="border-bottom: 1px solid #000; font-weight: bold;">{{ $setting->akuntan_sppg ?? 'Nurul Anniza, S.Ak' }}</td>
        </tr>
    </table>
</body>

</html>
