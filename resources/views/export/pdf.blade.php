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
