<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
</head>

<body>
    <table>
        <tr>
            <td colspan="4" style="text-align: center; font-weight: bold; font-size: 16px;">LAPORAN REALISASI ANGGARAN (LRA)</td>
        </tr>
        <tr>
            <td colspan="4"></td>
        </tr>
        <tr>
            <td></td>
            <td>Periode Awal :</td>
            <td colspan="2">{{ $startDate ? \Carbon\Carbon::parse($startDate)->format('d/m/Y') : '01/12/2025' }}</td>
        </tr>
        <tr>
            <td></td>
            <td>Periode Akhir :</td>
            <td colspan="2">{{ $endDate ? \Carbon\Carbon::parse($endDate)->format('d/m/Y') : '12/12/2025' }}</td>
        </tr>
        <tr>
            <td colspan="4"></td>
        </tr>
        <tr>
            <td>Nama SPPG :</td>
            <td>{{ $setting->nama_sppg ?? '03 Mandai' }}</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td>Kelurahan :</td>
            <td>{{ $setting->kelurahan ?? 'Bontoa' }}</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td>Kecamatan :</td>
            <td>{{ $setting->kecamatan ?? 'Mandai' }}</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td>Kabupaten/Kota :</td>
            <td>{{ $setting->kabupaten ?? 'Maros' }}</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td>Provinsi :</td>
            <td>{{ $setting->provinsi ?? 'Sulawesi Selatan' }}</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td colspan="4"></td>
        </tr>
        <tr style="text-align: center;">
            <td>Uraian</td>
            <td>Anggaran</td>
            <td>Realisasi</td>
            <td>Persentase</td>
        </tr>
        <tr>
            <td class="fw-bold">Penerimaan</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        @foreach ($penerimaanItems as $item)
        <tr>
            <td>{{ $item['uraian'] }}</td>
            <td>{{ number_format($item['anggaran'], 0, ',', '.') }}</td>
            <td>{{ number_format($item['realisasi'], 0, ',', '.') }}</td>
            <td>
                @php
                $percentage = $item['anggaran'] > 0 ? ($item['realisasi'] / $item['anggaran']) * 100 : 0;
                @endphp
                {{ number_format($percentage, 2, ',', '.') }}%
            </td>
        </tr>
        @endforeach
        <tr>
            <td class="fw-bold">Belanja</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        @foreach ($belanjaItems as $item)
        <tr>
            <td>{{ $item['uraian'] }}</td>
            <td>{{ number_format($item['anggaran'], 0, ',', '.') }}</td>
            <td>{{ number_format($item['realisasi'], 0, ',', '.') }}</td>
            <td>
                @php
                $percentage = $item['anggaran'] > 0 ? ($item['realisasi'] / $item['anggaran']) * 100 : 0;
                @endphp
                {{ number_format($percentage, 2, ',', '.') }}%
            </td>
        </tr>
        @endforeach
        <!-- Totals -->
        {{-- <tr style="font-weight: bold;"> --}}
            {{-- <td>Total Penerimaan</td> --}}
            {{-- <td>{{ number_format($totalAnggaranPenerimaan, 0, ',', '.') }}</td> --}}
            {{-- <td>{{ number_format($totalRealisasiPenerimaan, 0, ',', '.') }}</td> --}}
            {{-- <td> --}}
                {{-- @php --}}
                {{-- // $totalPercentagePenerimaan = $totalAnggaranPenerimaan > 0 ? ($totalRealisasiPenerimaan / --}}
                {{-- // $totalAnggaranPenerimaan) * 100 : 0; --}}
                {{-- // @endphp --}}
                {{-- {{ number_format($totalPercentagePenerimaan, 2, ',', '.') }}% --}}
            {{-- </td> --}}
        {{-- </tr> --}}
        {{-- <tr style="font-weight: bold;"> --}}
            {{-- <td>Total Belanja</td> --}}
            {{-- <td>{{ number_format($totalAnggaranBelanja, 0, ',', '.') }}</td> --}}
            {{-- <td>{{ number_format($totalRealisasiBelanja, 0, ',', '.') }}</td> --}}
            {{-- <td> --}}
                {{-- @php --}}
                {{-- // $totalPercentageBelanja = $totalAnggaranBelanja > 0 ? ($totalRealisasiBelanja / $totalAnggaranBelanja) * --}}
                {{-- // 100 : 0; --}}
                {{-- // @endphp --}}
                {{-- {{ number_format($totalPercentageBelanja, 2, ',', '.') }}% --}}
            {{-- </td> --}}
        {{-- </tr> --}}
        <tr>
            <td colspan="4"></td>
        </tr>
        <tr>
            <td colspan="4"></td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td style="text-align: right;">{{ $setting->kabupaten ?? 'Maros' }}, {{ date('d F Y') }}</td>
        </tr>
        <tr>
            <td>Mengetahui</td>
            <td colspan="3"></td>
        </tr>
        <tr>
            <td>Kepala SPPG,</td>
            <td colspan="2"></td>
            <td>Akuntan,</td>
        </tr>
        <tr>
            <td colspan="4"></td>
        </tr>
        <tr>
            <td colspan="4"></td>
        </tr>
        <tr>
            <td colspan="4"></td>
        </tr>
        <tr>
            <td colspan="4"></td>
        </tr>
        <tr>
            <td style="border-top: 1px solid #000;">{{ $setting->nama_sppi ?? 'Rina Fatma Sari, S.TR.Sos' }}</td>
            <td colspan="2"></td>
            <td style="border-top: 1px solid #000;">{{ $setting->akuntan_sppg ?? 'Nurul Anniza, S.Ak' }}</td>
        </tr>
    </table>
</body>

</html>