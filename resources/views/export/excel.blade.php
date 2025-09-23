<table border="1" cellspacing="0" cellpadding="5">
    <thead>
        <tr>
            <th colspan="9"><h2>Laporan Aktivitas</h2></th>
        </tr>
        <tr>
            <th style="text-align: center; vertical-align: middle;">No</th>
            <th style="text-align: center; vertical-align: middle;">Deskripsi</th>
            <th style="text-align: center; vertical-align: middle;">Catatan</th>
            <th style="text-align: center; vertical-align: middle;">Cabang</th>
            <th style="text-align: center; vertical-align: middle;">Kategori</th>
            <th style="text-align: center; vertical-align: middle;">Status</th>
            <th style="text-align: center; vertical-align: middle;">Tanggal Mulai</th>
            <th style="text-align: center; vertical-align: middle;">Tanggal Selesai</th>
            <th style="text-align: center; vertical-align: middle;">Personil</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($fieldworks as $i => $fw)
            <tr>
                <td style="text-align: center; vertical-align: middle;">{{ $i + 1 }}</td>
                <td style="text-align: center; vertical-align: middle;">{{ $fw->description }}</td>
                <td style="text-align: center; vertical-align: middle;">{{ $fw->note }}</td>
                <td style="text-align: center; vertical-align: middle;">{{ $fw->branch->name ?? '-' }}</td>
                <td style="text-align: center; vertical-align: middle;">{{ $fw->category->name ?? '-' }}</td>
                <td style="text-align: center; vertical-align: middle;">{{ $fw->status?->name ?? '-' }}</td>
                <td style="text-align: center; vertical-align: middle;">{{ $fw->start_date?->format('d-m-Y') }}</td>
                <td style="text-align: center; vertical-align: middle;">{{ $fw->end_date?->format('d-m-Y') }}</td>
                <td style="text-align: center; vertical-align: middle;">
                    @foreach ($fw->users as $user)
                        {{ $user->name }}<br>
                    @endforeach
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
