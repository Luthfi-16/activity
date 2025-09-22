<style>
    table {
        border-collapse: collapse;
        width: 100%;
        table-layout: fixed; /* biar kolom punya ukuran fix */
    }
    th, td {
        word-wrap: break-word;
        white-space: normal;
        vertical-align: top;
    }
    td {
        font-size: 12px; /* opsional biar muat lebih banyak */
    }
    th {
        text-align: left;
    }
    /* atur lebar kolom sesuai kebutuhan */
    th:nth-child(1), td:nth-child(1) { width: 5%; }   /* No */
    th:nth-child(2), td:nth-child(2) { width: 30%; }  /* Deskripsi */
    th:nth-child(3), td:nth-child(3) { width: 15%; }  /* Catatan */
    th:nth-child(4), td:nth-child(4) { width: 12%; }  /* Cabang */
    th:nth-child(5), td:nth-child(5) { width: 12%; }  /* Kategori */
    th:nth-child(6), td:nth-child(6) { width: 10%; }  /* Status */
    th:nth-child(7), td:nth-child(7) { width: 9%; }   /* Tanggal Mulai */
    th:nth-child(8), td:nth-child(8) { width: 9%; }   /* Tanggal Selesai */
    th:nth-child(9), td:nth-child(9) { width: 15%; }  /* Personil */
</style>

<h1 align="center">Laporan Aktivitas</h1>

<table border="1" cellspacing="0" cellpadding="5">
    <thead>
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
                <td style="text-align: center; vertical-align: middle;
                    @if($fw->status == 'pending') background-color:#fff3cd; color:#856404;
                    @elseif($fw->status == 'on_progres') background-color:#cce5ff; color:#004085;
                    @elseif($fw->status == 'done') background-color:#d4edda; color:#155724;
                    @elseif($fw->status == 'cancel') background-color:#f8d7da; color:#721c24;
                    @else background-color:#e2e3e5; color:#383d41;
                    @endif
                ">
                    {{ $fw->status ?? '-' }}
                </td>
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
