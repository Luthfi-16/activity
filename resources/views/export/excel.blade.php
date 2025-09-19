<table border="1" cellspacing="0" cellpadding="5">
    <thead>
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
                <td style="vertical-align: top;">{{ $fw->status->name ?? '-' }}</td>
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
