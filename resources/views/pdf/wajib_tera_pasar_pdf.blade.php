<!-- resources/views/pdf/wajib_tera_pasar_pdf.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wajib Tera Pasar PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        ul {
            margin: 0;
            padding: 0;
            list-style-type: none;
        }
        li {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <h1>Wajib Tera Pasar</h1>
    <table>
        <thead>
            <tr>
                <th>Pemilik UTTP</th>
                <th>NIK</th>
                <th>Pasar</th>
                <th>UTTP Details</th>
                {{-- <th>Created At</th>
                <th>Updated At</th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach ($wajibTeraPasars as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->nik }}</td>
                    <td>{{ $item->pasar->name }}</td>
                    <td>
                        <ul>
                            @foreach ($item->uttpWajibTeraPasar as $uttp)
                                <li>
                                    {{ $uttp->jenisUttp->name }} |
                                    Kap Maks: {{ number_format($uttp->kap_max, 0, '.', '.') }} {{ $uttp->satuan->name }},
                                    Daya Baca: {{ $uttp->daya_baca }}
                                </li>
                            @endforeach
                        </ul>
                    </td>
                    {{-- <td>{{ $item->created_at->format('Y-m-d H:i:s') }}</td>
                    <td>{{ $item->updated_at->format('Y-m-d H:i:s') }}</td> --}}
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
