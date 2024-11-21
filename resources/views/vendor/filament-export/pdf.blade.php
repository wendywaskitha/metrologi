<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ $fileName }}</title>
    <style type="text/css" media="all">
        * {
            font-family: DejaVu Sans, sans-serif !important;
        }

        html {
            width: 100%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            border-radius: 10px 10px 10px 10px;
        }

        table td,
        th {
            border-color: black;
            /* Change border color to solid black */
            border-style: solid;
            /* Ensure border is solid */
            border-width: 1px;
            font-size: 12px;
            /* Set a smaller font size */
            overflow: hidden;
            padding: 5px;
            /* Adjust padding for smaller font */
            word-break: normal;
        }

        table th {
            font-weight: normal;
        }

        .summary {
            margin-top: 20px;
            font-size: 10px;
            /* Adjust font size for summary */
        }
    </style>
</head>

<body>
    <h4>Pasar : {{ $pasarName }}</h4>
    <table>
        <tr>
            @foreach ($columns as $column)
                <th>
                    {{ $column->getLabel() }}
                </th>
            @endforeach
        </tr>
        @foreach ($rows as $row)
            <tr>
                @foreach ($columns as $column)
                    <td>
                        {{-- Use strip_tags() to remove any HTML from the row data --}}
                        {{ strip_tags($row[$column->getName()]) }}
                    </td>
                @endforeach
            </tr>
        @endforeach
    </table>

    {{-- Summary Section --}}
    <div class="summary">
        <h4>Total Per Jenis Uttp</h4>
        <ul>
            @foreach ($totalByJenisUttp as $jenisUttpName => $count)
                <li>{{ $jenisUttpName }}: {{ $count }}</li>
            @endforeach
        </ul>

        <h4>Total Semua Jenis Uttp</h4>
        <p>Total: {{ $totalSemuaJenisUttp }}</p>
    </div>
</body>

</html>
