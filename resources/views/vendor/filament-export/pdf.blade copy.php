<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <style type="text/css" media="all">
        * {
            font-family: DejaVu Sans, sans-serif !important;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
            padding: 5px;
            font-size: 12px;
        }

        .summary {
            margin-top: 20px;
            font-size: 10px;
        }

        .uttp-details {
            margin: 0;
            padding: 0;
            /* Remove padding */
            list-style-type: none;
            /* Remove default list styling */
            display: flex;
            /* Use Flexbox */
            flex-wrap: wrap;
            /* Allow items to wrap to the next line */
            gap: 10px;
            /* Space between items */
        }

        .uttp-details li {
            flex: 0 0 calc(50% - 10px);
            /* Each item takes up approximately half the width */
            padding: 5px 10px;
            /* Padding for each item */
            border: 1px solid #e5e7eb;
            /* Optional: border for each item */
            border-radius: 4px;
            /* Optional: rounded corners */
            background-color: #f9f9f9;
            /* Optional: background color */
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            /* Optional: shadow for depth */
            font-size: 12px;
            /* Font size for list items */
        }
    </style>
</head>

<body>
    <h4>Pasar: {{ $pasarName }}</h4>
    <table>
        <thead>
            <tr>
                @foreach ($columns as $column)
                    <th>{{ $column->getLabel() }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($rows as $row)
                <tr>
                    @foreach ($columns as $column)
                        <td>
                            @if ($column->getName() === 'UttpWajibTeraPasar')
                                <ul class="uttp-details">
                                    @php
                                        $uttpDetails = explode("\n", strip_tags($row[$column->getName()] ?? ''));
                                    @endphp
                                    @forelse ($uttpDetails as $detail)
                                        <li>{{ $detail }}</li>
                                    @empty
                                        <li>No UTTP details</li>
                                    @endforelse
                                </ul>
                            @else
                                {{ strip_tags($row[$column->getName()] ?? '') }}
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <h4>Total Per Jenis Uttp</h4>
        <ul>
            @foreach ($totalByJenisUttp as $jenisUttpName => $count)
                <li>{{ $jenisUttpName }}: {{ $count }}</li>
            @endforeach
        </ul>

        <h4>Total Semua Jenis Uttp : {{ $totalSemuaJenisUttp }}</h4>
    </div>
</body>

</html>
