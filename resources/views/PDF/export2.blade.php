<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Memori Extension RSUD Blambangan Banyuwangi</title>
    <style>
        @page {
            /* size: landscape; */
            margin: 10px;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
        }

        .kop-surat {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .kop-surat h1 {
            font-size: 14pt;
            margin: 0;
        }

        .kop-surat p {
            font-size: 10pt;
            margin: 0;
        }

        .table-container {
            display: flex;
            justify-content: space-between;
            margin: 0 10px;
        }

        table {
            width: 48%;
            border-collapse: collapse;
            font-size: 9pt;
        }

        table th,
        table td {
            border: 2px solid #000;
            padding: 1px;
            text-align: left;
        }

        table th {
            background-color: #ddd;
        }

        .cara-pakai {
            text-align: left;
            margin-top: 20px;
        }

        .cara-pakai h4 {
            font-size: 12pt;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .cara-pakai p {
            font-size: 10pt;
            margin: 0;
        }

        .cara-pakai .highlight {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="kop-surat">
        <h1>DAFTAR MEMORI TELEPON RSUD BLAMBANGAN BANYUWANGI</h1>
        <p>Jl. Letkol Istiqlah No.49, Singonegaran, Kec. Banyuwangi, Kabupaten Banyuwangi, Jawa Timur 68415</p>
        <p>Telepon: (0333) 421118 FAX: 0333 - 421072</p>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Extension</th>
                    <th>Nama</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($leftTableData as $key => $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->memori }}</td>
                        <td>{{ $item->nama }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Extension</th>
                    <th>Nama</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rightTableData as $key => $item)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $item->memori }}</td>
                        <td>{{ $item->nama }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="cara-pakai">
        <h4>Cara Pakai :</h4>
        <p>1. Telp. Keluar: Angkat Gagang - Tekan Memori yang di kehendaki (<span class="highlight">*2200 - *4999</span>)
            - Tunggu Sambung</p>
        <p>2. TRANSFER TELEPON MASUK/KELUAR: - TEKAN <span class="highlight">FLASH</span> - No. Ext Yang di kehendaki</p>
    </div>
</body>

</html>
