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
            <td>{{ $setting->nama_sppg ?? '03 Mandai' }}</td>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td>Kelurahan :</td>
            <td>{{ $setting->kelurahan ?? 'Bontoa' }}</td>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td>Kecamatan :</td>
            <td>{{ $setting->kecamatan ?? 'Mandai' }}</td>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td>Kabupaten/Kota :</td>
            <td>{{ $setting->kabupaten ?? 'Maros' }}</td>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td>Provinsi :</td>
            <td>{{ $setting->provinsi ?? 'Sulawesi Selatan' }}</td>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td colspan="7"></td>
        </tr>
        <tr style="text-align: center;">
            <td>No</td>
            <td>Kategori</td>
            <td>Nama</td>
            <td>No HP</td>
            <td>Tempat/Tgl Lahir</td>
            <td>Kelamin</td>
            <td>Alamat</td>
        </tr>
        @foreach ($karyawans as $index => $karyawan)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $karyawan->kategori->nama ?? '-' }}</td>
                <td>{{ $karyawan->nama }}</td>
                <td>{{ $karyawan->no_hp ?? '-' }}</td>
                <td>
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
                <td>{{ $karyawan->kelamin ?? '-' }}</td>
                <td>{{ $karyawan->alamat ?? '-' }}</td>
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
            <td colspan="6"></td>
            <td style="text-align: right;">Jakarta, {{ date('d F Y') }}</td>
        </tr>
        <tr>
            <td>Mengetahui</td>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td>Kepala SPPG,</td>
            <td colspan="5"></td>
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
            <td style="border-top: 1px solid #000;">{{ $setting->nama_sppi ?? 'Rina Fatma Sari, S.TR.Sos' }}</td>
            <td colspan="5"></td>
            <td style="border-top: 1px solid #000;">{{ $setting->akuntan_sppg ?? 'Nurul Anniza, S.Ak' }}</td>
        </tr>
    </table>
</body>

</html>
