<!DOCTYPE html>
<html>
<head>
    <title>Log Aktivitas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .table-responsive {
            overflow-x: auto; /* Membuat tabel responsif */
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Log Aktivitas</h1>

    <form action="{{ route('activity-log.index') }}" method="GET" class="mb-3">
        <div class="row">
            <div class="col-md-4">
                <label for="end_date" class="form-label">Tanggal:</label>
                <input type="date" name="end_date" id="end_date" class="form-control flatpickr" value="{{ request('end_date') }}">
            </div>
            <div class="col-md-4 mt-auto">
                <button type="submit" class="btn btn-primary">Cari</button>
                <a href="{{ route('activity-log.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </div>
    </form>

    @if ($activities->isEmpty())
        <p>Tidak ada aktivitas yang tercatat.</p>
    @else
        <div class="table-responsive"> {{-- Bungkus tabel dengan div responsif --}}
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Deskripsi</th>
                    <th>Subjek</th>
                    <th>Perubahan</th>
                    <th>Pengguna</th>
                    <th>Tanggal dan Waktu</th>
                    <th>IP Address</th>
                    <th>Device (User Agent)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($activities as $activity)
                    <tr>
                        <td>{{ $activity->description }}</td>
                        <td>
                            @if ($activity->subject)
                                @if ($activity->subject_type === 'App\Models\Mahasiswa')
                                    Mahasiswa: {{ $activity->subject->nama }} (NIM: {{ $activity->subject->nim }})
                                @else
                                    {{ $activity->subject_type }} (ID: {{ $activity->subject->id }})
                                @endif
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if ($activity->changes)
                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#changesModal{{ $loop->iteration }}">
                                    Lihat Perubahan
                                </button>

                                <div class="modal fade" id="changesModal{{ $loop->iteration }}" tabindex="-1" aria-labelledby="changesModalLabel{{ $loop->iteration }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="changesModalLabel{{ $loop->iteration }}">Perubahan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <pre>{{ json_encode($activity->changes, JSON_PRETTY_PRINT) }}</pre>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if ($activity->causer)
                                {{ $activity->causer->name ?? $activity->causer->email ?? $activity->causer->id }}
                            @else
                                Sistem
                            @endif
                        </td>
                        <td>{{ $activity->created_at->format('d/m/Y H:i:s') }}</td>
                        <td class="text-truncate" style="max-width: 150px;" title="{{ $activity->properties['ip_address'] ?? '-' }}">{{ $activity->properties['ip_address'] ?? '-' }}</td> {{-- Menangani tampilan IP yang panjang --}}
                        <td class="text-truncate" style="max-width: 200px;" title="{{ $activity->properties['user_agent'] ?? '-' }}">{{ $activity->properties['user_agent'] ?? '-' }}</td> {{-- Menangani tampilan User Agent yang panjang --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>
        {{ $activities->links() }}
    @endif
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr(".flatpickr", {
            dateFormat: "Y-m-d",
        });
    </script>
</body>
</html>