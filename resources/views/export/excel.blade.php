<table border="1" cellspacing="0" cellpadding="5">
    <thead>
        <tr>
            <th colspan="9"><h2>Laporan Aktivitas</h2></th>
        </tr>
        <tr>
            <th>No</th>
            <th>Deskripsi</th>
            <th>Catatan</th>
            <th>Cabang</th>
            <th>Kategori</th>
            <th>Status</th>
            <th>Tanggal Mulai</th>
            <th>Tanggal Selesai</th>
            <th>Personil</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($fieldworks as $i => $fw)
            <tr>
                <td style="vertical-align: top;">{{ $i + 1 }}</td>
                <td style="vertical-align: top;">{{ $fw->description }}</td>
                <td style="vertical-align: top;">{{ $fw->note }}</td>
                <td style="vertical-align: top;">{{ $fw->branch->name ?? '-' }}</td>
                <td style="vertical-align: top;">{{ $fw->category->name ?? '-' }}</td>
                <td style="vertical-align: top;
                    @if($fw->status == 'pending') background-color:#fff3cd; color:#856404;
                    @elseif($fw->status == 'on_progres') background-color:#cce5ff; color:#004085;
                    @elseif($fw->status == 'done') background-color:#d4edda; color:#155724;
                    @elseif($fw->status == 'cancel') background-color:#f8d7da; color:#721c24;
                    @else background-color:#e2e3e5; color:#383d41;
                    @endif
                ">
                    {{ $fw->status ?? '-' }}
                </td>
                <td style="vertical-align: top;">{{ $fw->start_date?->format('d-m-Y') }}</td>
                <td style="vertical-align: top;">{{ $fw->end_date?->format('d-m-Y') }}</td>
                <td style="vertical-align: top;">
                    @foreach ($fw->users as $user)
                        {{ $user->name }}<br>
                    @endforeach
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
