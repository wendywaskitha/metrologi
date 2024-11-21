<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $fileName }}</title>
    <style type="text/css" media="all">
        * {
            font-family: DejaVu Sans, sans-serif !important;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
        }

        table td,
        table th {
            border: 1px solid black;
            padding: 5px;
            font-size: 10px;
        }

        .uttp-details {
            margin: 0;
            padding: 0;
            list-style-type: none;
        }

        .uttp-detail-header {
            font-weight: bold;
            background-color: #f0f0f0;
            padding: 3px;
        }

        .uttp-detail-content {
            display: flex;
        }

        .uttp-primary-details,
        .uttp-secondary-details {
            flex: 1;
            padding: 3px;
        }

        .uttp-detail-label {
            /* font-weight: bold; */
            margin-right: 5px;
        }

        .uttp-status-sah {
            color: green;
        }

        .uttp-status-batal {
            color: red;
        }

        .summary {
            margin-top: 15px;
            border-top: 1px solid #e0e0e0;
            padding-top: 10px;
        }

        .summary h4 {
            color: #333;
            font-size: 11px;
            margin-bottom: 8px;
            text-transform: uppercase;
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 5px;
        }

        .summary ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .summary ul li {
            display: flex;
            justify-content: space-between;
            font-size: 10px;
            padding: 3px 0;
            border-bottom: 1px dotted #d0d0d0;
        }

        .summary ul li:last-child {
            border-bottom: none;
        }

        .summary ul li .jenis-uttp {
            color: #555;
            font-weight: normal;
        }

        .summary ul li .count {
            color: #333;
            font-weight: bold;
        }

        .summary .total-section {
            display: flex;
            justify-content: space-between;
            margin-top: 8px;
            padding-top: 5px;
            border-top: 1px solid #e0e0e0;
            font-size: 10px;
        }

        .summary .total-section .total-label {
            color: #555;
        }

        .summary .total-section .total-value {
            color: #333;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h3>Pasar : {{ $pasarName }}</h3>
    <table>
        <tr>
            @foreach ($columns as $column)
                <th>{{ $column->getLabel() }}</th>
            @endforeach
        </tr>
        @foreach ($rows as $row)
            <tr>
                @foreach ($columns as $column)
                    <td>
                        @if ($column->getName() === 'UttpWajibTeraPasar')
                            @php
                                $uttpDetailsRaw = $row[$column->getName()] ?? '';
                            @endphp

                            @if ($uttpDetailsRaw)
                                <ul class="uttp-details">
                                    @foreach (explode("\n", $uttpDetailsRaw) as $detail)
                                        @if (trim($detail))
                                            @php
                                                $detailParts = json_decode($detail, true);
                                            @endphp
                                            <li>
                                                <div class="uttp-detail-header">
                                                    {{ $detailParts['header'] }}
                                                </div>
                                                <div class="uttp-detail-content">
                                                    <div class="uttp-primary-details">
                                                        @foreach ($detailParts['details']['primary'] as $label => $value)
                                                            <div>
                                                                <span
                                                                    class="uttp-detail-label">{{ $label }}:</span>
                                                                <span
                                                                    class="uttp-detail-value">{{ $value }}</span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="uttp-secondary-details">
                                                        @foreach ($detailParts['details']['secondary'] as $label => $value)
                                                            <div>
                                                                <span
                                                                    class="uttp-detail-label">{{ $label }}:</span>
                                                                <span class="uttp-detail-value">
                                                                    @if ($label === 'Status')
                                                                        <span
                                                                            class="{{ strpos($value, 'Sah') !== false ? 'uttp-status-sah' : 'uttp-status-batal' }}">
                                                                            {{ $value }}
                                                                        </span>
                                                                    @else
                                                                        {{ $value }}
                                                                    @endif
                                                                </span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            @else
                                -
                            @endif
                        @else
                            {{ strip_tags($row[$column->getName()] ?? '') }}
                        @endif
                    </td>
                @endforeach
            </tr>
        @endforeach
    </table>

    {{-- Summary Section --}}
    <div class="summary">
        <h4>Rekap Total UTTP : {{ $pasarName }}</h4>
        <ul>
            @foreach ($totalByJenisUttp as $jenisUttpName => $count)
                <li>
                    <span class="jenis-uttp">{{ $jenisUttpName }}</span>
                    <span class="count">{{ $count }}</span>
                </li>
            @endforeach
        </ul>

        <div class="total-section">
            <span class="total-label">Total Keseluruhan</span>
            <span class="total-value">{{ $totalSemuaJenisUttp }}</span>
        </div>
    </div>
</body>

</html>
