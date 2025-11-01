<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Tanda Lapor Kehilangan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            line-height: 1.5;
            margin: 30px;
        }

        .center {
            text-align: center;
        }

        .underline {
            text-decoration: underline;
            font-weight: bold;
        }

        .header {
            text-align: center;
            line-height: 1.2;

        }

        .ttd {
            text-align: right;
            margin-top: 50px;
        }

        table {
            width: 100%;
        }

        td {
            vertical-align: top;
        }

        .upperline {
            border-top: 1px solid #000;
            padding-top: 0px;
            display: inline-block;
        }
    </style>
</head>

<body>
    <table style="margin-top: -40;">
        <tr>
            <td width="50%">
                <div class="header">
                    KEPOLISIAN NEGARA REPUBLIK INDONESIA<br>
                    DAERAH JAWA TIMUR<br>
                    RESOR PACITAN<br>
                    Jalan A. Yani 60 Pacitan 63512
                    <hr style="border: 0.5px solid #000; margin-top: 0;">
                </div>
            </td>
            <td></td>
        </tr>
    </table>

    <div class="center">
        <img style="margin-top: 10; margin-bottom: 10;" src="{{ public_path('assets/images/polri.png') }}" width="75px" height="75px" alt=""><br>
        <b>SURAT KETERANGAN TANDA LAPOR KEHILANGAN</b><br>
        <span class="upperline">NOMOR : {{ $no_surat }}</span>
    </div>

    <br>
    <p style="text-align: justify; margin-top: 0;">
        Yang bertanda tangan di bawah ini menerangkan bahwa pada hari
        {{ \Carbon\Carbon::parse($surat->created_at)->locale('id')->translatedFormat('l, d F Y') }}
        pukul {{ \Carbon\Carbon::parse($surat->created_at)->format('H:i') }} WIB,
        telah datang ke Polres Pacitan seorang {{ strtolower($surat->jk) }} yang mengaku bernama :
    </p>

    <table style="border-collapse: collapse; line-height: 1; font-size: 10pt;">
        <tr>
            <td width="100">Nama</td>
            <td>: <u>{{ strtoupper($surat->name) }}</u></td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>: {{ $surat->nik }}</td>
        </tr>
        <tr>
            <td>Tempat / Tgl Lahir</td>
            <td>: {{ strtoupper($surat->tempat_lahir) }}, {{ \Carbon\Carbon::parse($surat->tgl_lahir)->translatedFormat('d-m-Y') }}</td>
        </tr>
        <tr>
            <td>Agama</td>
            <td>: {{ strtoupper($surat->agama) }}</td>
        </tr>
        <tr>
            <td>Kewarganegaraan</td>
            <td>: {{ strtoupper($surat->warganegara) }}</td>
        </tr>
        <tr>
            <td>Pekerjaan</td>
            <td>: {{ strtoupper($surat->pekerjaan) }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>: {{ strtoupper($surat->alamat) }}</td>
        </tr>
        <tr>
            <td>No. Telp</td>
            <td>: {{ $surat->no_telp }}</td>
        </tr>
    </table>

    <p style="text-align: justify;">
        - Telah melaporkan tentang kehilangan barang/surat berharga berupa : -------------------------------------------------
    </p>
    <p style="text-align: justify;text-transform: uppercase;">
        {!! nl2br(e($surat->desc)) !!}
    </p>
    <p style="text-align: justify;">
        - Surat ini bukan merupakan pengganti barang/surat yang hilang namun sebagai syarat pengurusan
        barang/surat yang hilang berlaku selama 30 (tiga puluh) hari, terhitung sejak dikeluarkannya surat ini.
    </p>

    <p style="text-align: justify;">
        Demikian Surat Tanda Penerimaan Laporan ini dibuat untuk dapat dipergunakan sebagaimana mestinya.
    </p>

    <table class="center">
        <tr>
            <td width="50%" class="center">
                <p style="color:white;">|</p>
                <p><b>PELAPOR</b><br><span style="color:white;">|</span></p>
                <br><br><br>
                <p><b><u>{{ strtoupper($surat->name) }}</u></b>
                </p>
            </td>
            <td width="50%" class="center">
                <p>Pacitan, {{ $tanggal }}</p>
                <p><b>a.n. KEPALA KEPOLISIAN RESOR PACITAN<br>
                        {{ $surat->ttd->jabatan}}</b>
                </p>
                <!-- Container tanda tangan -->
                <div style="height: 80px; position: relative; margin-top: -10px;    ">
                    <img
                        src="{{ public_path('storage/' . $surat->ttd->ttd) }}"
                        width="300"
                        alt="TTD"
                        style="margin-top: -50px; opacity: 0.9;">
                </div>
                <p style="margin-top: 0;"><b>{{ $surat->ttd->name }}</b><br>
                    <span class="upperline"><b>{{ $surat->ttd->pangkat}} NRP {{ $surat->ttd->nrp}}</b></span>
                </p>
            </td>
            <td></td>
        </tr>
    </table>

</body>

</html>
