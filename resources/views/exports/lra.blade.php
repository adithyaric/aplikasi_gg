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
        {{-- <tr> --}}
            {{-- <td></td> --}}
            {{-- <td>Periode Awal :</td> --}}
            {{-- <td style="font-weight: bold;" colspan="2">{{ $startDate ? \Carbon\Carbon::parse($startDate)->format('d/m/Y') : '01/12/2025' }}</td> --}}
        {{-- </tr> --}}
        {{-- <tr> --}}
            {{-- <td></td> --}}
            {{-- <td>Periode Akhir :</td> --}}
            {{-- <td style="font-weight: bold;" colspan="2">{{ $endDate ? \Carbon\Carbon::parse($endDate)->format('d/m/Y') : '12/12/2025' }}</td> --}}
        {{-- </tr> --}}
        {{-- <tr> --}}
            {{-- <td colspan="4"></td> --}}
        {{-- </tr> --}}
        <tr>
            <td>Nama SPPG :</td>
            <td style="font-weight: bold;">{{ $setting->nama_sppg ?? '03 Mandai' }}</td>
            <td>Periode Awal :</td>
            <td style="font-weight: bold;">
                {{ $startDate ? \Carbon\Carbon::parse($startDate)->format('d/m/Y') : '01/12/2025' }}
            </td>
        </tr>

        <tr>
            <td>Kelurahan :</td>
            <td style="font-weight: bold;">{{ $setting->kelurahan ?? 'Bontoa' }}</td>
            <td>Periode Akhir :</td>
            <td style="font-weight: bold;">
                {{ $endDate ? \Carbon\Carbon::parse($endDate)->format('d/m/Y') : '12/12/2025' }}
            </td>
        </tr>
        <tr>
            <td>Kecamatan :</td>
            <td style="font-weight: bold;">{{ $setting->kecamatan ?? 'Mandai' }}</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td>Kabupaten/Kota :</td>
            <td style="font-weight: bold;">{{ $setting->kabupaten ?? 'Maros' }}</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td>Provinsi :</td>
            <td style="font-weight: bold;">{{ $setting->provinsi ?? 'Sulawesi Selatan' }}</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td colspan="4"></td>
        </tr>
        <tr style="text-align: center; font-weight: bold;">
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Uraian</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Anggaran</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Realisasi</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Persentase</td>
        </tr>
        <tr>
            <td style="font-weight: bold; border: 1px solid #000;" class="fw-bold">Penerimaan</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;"></td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;"></td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;"></td>
        </tr>
        @foreach ($penerimaanItems as $item)
        <tr>
            <td style="border: 1px solid #000;">{{ $item['uraian'] }}</td>
            <td style="border: 1px solid #000;">Rp{{ number_format($item['anggaran'], 2, '.', ',') }}</td>
            <td style="border: 1px solid #000;">Rp{{ number_format($item['realisasi'], 2, '.', ',') }}</td>
            <td style="border: 1px solid #000;">
                @php
                $percentage = $item['anggaran'] > 0 ? ($item['realisasi'] / $item['anggaran']) * 100 : 0;
                @endphp
                {{ number_format($percentage, 2, ',', '.') }}%
            </td>
        </tr>
        @endforeach
        <tr>
            <td style="font-weight: bold; border: 1px solid #000;" class="fw-bold">Belanja</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;"></td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;"></td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;"></td>
        </tr>
        @foreach ($belanjaItems as $item)
        <tr>
            <td style="border: 1px solid #000;">{{ $item['uraian'] }}</td>
            <td style="border: 1px solid #000;">Rp{{ number_format($item['anggaran'], 2, '.', ',') }}</td>
            <td style="border: 1px solid #000;">Rp{{ number_format($item['realisasi'], 2, '.', ',') }}</td>
            <td style="border: 1px solid #000;">
                @php
                $percentage = $item['anggaran'] > 0 ? ($item['realisasi'] / $item['anggaran']) * 100 : 0;
                @endphp
                {{ number_format($percentage, 2, ',', '.') }}%
            </td>
        </tr>
        @endforeach
        <!-- Totals -->
        {{-- <tr style="font-weight: bold;"> --}}
            {{-- <td style="border: 1px solid #000;">Total Penerimaan</td> --}}
            {{-- <td style="border: 1px solid #000;">{{ $totalAnggaranPenerimaan }}</td> --}}
            {{-- <td style="border: 1px solid #000;">{{ $totalRealisasiPenerimaan }}</td> --}}
            {{-- <td style="border: 1px solid #000;"> --}}
                {{-- @php --}}
                {{-- // $totalPercentagePenerimaan = $totalAnggaranPenerimaan > 0 ? ($totalRealisasiPenerimaan / --}}
                {{-- // $totalAnggaranPenerimaan) * 100 : 0; --}}
                {{-- // @endphp --}}
                {{-- {{ $totalPercentagePenerimaan, 2, ',', '.') }}% --}}
            {{-- </td> --}}
        {{-- </tr> --}}
        {{-- <tr style="font-weight: bold;"> --}}
            {{-- <td style="border: 1px solid #000;">Total Belanja</td> --}}
            {{-- <td style="border: 1px solid #000;">{{ $totalAnggaranBelanja }}</td> --}}
            {{-- <td style="border: 1px solid #000;">{{ $totalRealisasiBelanja }}</td> --}}
            {{-- <td style="border: 1px solid #000;"> --}}
                {{-- @php --}}
                {{-- // $totalPercentageBelanja = $totalAnggaranBelanja > 0 ? ($totalRealisasiBelanja / $totalAnggaranBelanja) * --}}
                {{-- // 100 : 0; --}}
                {{-- // @endphp --}}
                {{-- {{ $totalPercentageBelanja, 2, ',', '.') }}% --}}
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
            <td style="border-bottom: 1px solid #000; font-weight: bold;">{{ $setting->nama_sppi ?? 'Rina Fatma Sari, S.TR.Sos' }}</td>
            <td colspan="2"></td>
            <td style="border-bottom: 1px solid #000; font-weight: bold;">{{ $setting->akuntan_sppg ?? 'Nurul Anniza, S.Ak' }}</td>
        </tr>
    </table>
</body>

</html>