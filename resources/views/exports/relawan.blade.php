<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
</head>

<body>
    <table>
        <tr>
            <td colspan="7" style="text-align: center; font-weight: bold; font-size: 16px;">RELAWAN</td>
        </tr>
        <tr>
            <td colspan="7"></td>
        </tr>
        <tr>
            <td>Nama SPPG :</td>
            <td style="font-weight: bold;">{{ $setting->nama_sppg ?? '03 Mandai' }}</td>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td>Kelurahan :</td>
            <td style="font-weight: bold;">{{ $setting->kelurahan ?? 'Bontoa' }}</td>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td>Kecamatan :</td>
            <td style="font-weight: bold;">{{ $setting->kecamatan ?? 'Mandai' }}</td>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td>Kabupaten/Kota :</td>
            <td style="font-weight: bold;">{{ $setting->kabupaten ?? 'Maros' }}</td>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td>Provinsi :</td>
            <td style="font-weight: bold;">{{ $setting->provinsi ?? 'Sulawesi Selatan' }}</td>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td colspan="7"></td>
        </tr>
        <tr style="text-align: center; font-weight: bold;">
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">No</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Kategori</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Nama</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">No HP</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Tempat/Tgl Lahir</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Kelamin</td>
            <td style="text-align: center; font-weight: bold; border: 1px solid #000;">Alamat</td>
        </tr>
        @foreach ($karyawans as $index => $karyawan)
            <tr>
                <td style="border: 1px solid #000;">{{ $index + 1 }}</td>
                <td style="border: 1px solid #000;">{{ $karyawan->kategori->nama ?? '-' }}</td>
                <td style="border: 1px solid #000;">{{ $karyawan->nama }}</td>
                <td style="border: 1px solid #000;">{{ $karyawan->no_hp ?? '-' }}</td>
                <td style="border: 1px solid #000;">
                    @if ($karyawan->lahir_tempat || $karyawan->lahir_tanggal)
                        {{ $karyawan->lahir_tempat ?? '' }}
                        @if ($karyawan->lahir_tanggal)
                            / {{ \Carbon\Carbon::parse($karyawan->lahir_tanggal)->formatId('d F Y') }}
                            @php
                                $umur = \Carbon\Carbon::parse($karyawan->lahir_tanggal)->age;
                            @endphp
                            ({{ $umur }})
                        @endif
                    @else
                        -
                    @endif
                </td>
                <td style="border: 1px solid #000;">{{ $karyawan->kelamin ?? '-' }}</td>
                <td style="border: 1px solid #000;">{{ $karyawan->alamat ?? '-' }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="7"></td>
        </tr>
        <tr>
            <td colspan="7"></td>
        </tr>
        <tr>
            <td colspan="7"></td>
        </tr>
        <tr>
            <td colspan="7"></td>
        </tr>
        <tr>
            <td colspan="5"></td>
            <td style="text-align: right;">{{ $setting->kabupaten ?? 'Maros' }}, {{ date('d F Y') }}</td>
            <td></td>
        </tr>
        <tr>
            <td>Mengetahui</td>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td>Kepala SPPG,</td>
            <td colspan="4"></td>
            <td>Akuntan,</td>
        </tr>
        <tr>
            <td colspan="7"></td>
        </tr>
        <tr>
            <td colspan="7"></td>
        </tr>
        <tr>
            <td colspan="7"></td>
        </tr>
        <tr>
            <td colspan="7"></td>
        </tr>
        <tr>
            <td style="border-bottom: 1px solid #000; font-weight: bold;">{{ $setting->nama_sppi ?? 'Rina Fatma Sari, S.TR.Sos' }}</td>
            <td colspan="4"></td>
            <td style="border-bottom: 1px solid #000; font-weight: bold;">{{ $setting->akuntan_sppg ?? 'Nurul Anniza, S.Ak' }}</td>
        </tr>
    </table>
</body>

</html>
