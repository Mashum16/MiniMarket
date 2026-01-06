@extends('backend.v_layouts.admin')

@section('title', 'Audit Log')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Audit Log</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>User</th>
                        <th>Action</th>
                        <th>Table</th>
                        <th>Record ID</th>
                        <th>Description</th>
                        <th>IP</th>
                        <th>User Agent</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($Logs as $log)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $log->user?->name ?? 'Guest / Unknown' }}</td>
                        <td>{{ $log->action }}</td>
                        <td>{{ $log->table_name ?? '-' }}</td>
                        <td>{{ $log->record_id ?? '-' }}</td>
                        <td>{{ $log->description }}</td>
                        <td>{{ $log->ip_address }}</td>
                        <td title="{{ $log->user_agent }}">{{ Str::limit($log->user_agent, 40) }}</td>
                        <td>{{ $log->created_at->format('d-m-Y H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
