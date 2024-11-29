<div class="p-4">
    <div class="grid grid-cols-2 gap-4">
        <div>
            <strong>Jenis UTTP:</strong> {{ $record->jenisUttp->name ?? 'N/A' }}
        </div>
        <div>
            <strong>Merek:</strong> {{ $record->merk }}
        </div>
        <div>
            <strong>Kapasitas Maksimum:</strong>
            {{ number_format($record->kap_max, 0, ',', '.') }} {{ $record->satuan->name ?? 'N/A' }}
        </div>
        <div>
            <strong>Status:</strong> {{ ucfirst($record->status) }}
        </div>
        <div>
            <strong>Catatan:</strong> {{ $record->notes ?? 'N/A' }}
        </div>
        <div>
            <strong>Dibuat Oleh:</strong> {{ $record->created_by ? $record->creator->name : 'Sistem' }}
        </div>
    </div>

    <h3 class="mt-4">History Tanggal Uji dan Expired:</h3>
    <div class="grid grid-cols-1 gap-4">
        @foreach ($record->uttpWajibTeraPasar as $uttp)
            <h4>UTTP: {{ $uttp->jenisUttp->name ?? 'N/A' }}</h4>
            <ul>
                @if ($uttp->histories && $uttp->histories->isNotEmpty())
                    @foreach ($uttp->histories as $history)
                        <li>
                            <strong>Tanggal Uji:</strong> {{ $history->tgl_uji ? \Carbon\Carbon::parse($history->tgl_uji)->format('d-m-Y') : 'N/A' }} <br>
                            <strong>Tanggal Expired:</strong> {{ $history->expired ? \Carbon\Carbon::parse($history->expired)->format('d-m-Y') : 'N/A' }}
                        </li>
                    @endforeach
                @else
                    <li>No history available.</li>
                @endif
            </ul>
        @endforeach
    </div>
</div>
