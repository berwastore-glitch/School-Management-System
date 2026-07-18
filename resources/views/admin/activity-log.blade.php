@extends('layouts.admin')

@section('title', 'Activity Log - SchoolMS Admin')
@section('page_title', 'Activity Log')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-muted">Track all actions performed by users in the system</p>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">User</label>
                <select name="user_id" class="form-select">
                    <option value="">All Users</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ ucfirst($user->role) }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Action</label>
                <select name="action" class="form-select">
                    <option value="">All Actions</option>
                    <option value="created" {{ request('action') == 'created' ? 'selected' : '' }}>Created</option>
                    <option value="updated" {{ request('action') == 'updated' ? 'selected' : '' }}>Updated</option>
                    <option value="deleted" {{ request('action') == 'deleted' ? 'selected' : '' }}>Deleted</option>
                    <option value="viewed" {{ request('action') == 'viewed' ? 'selected' : '' }}>Viewed</option>
                    <option value="logged_in" {{ request('action') == 'logged_in' ? 'selected' : '' }}>Login</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">From</label>
                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">To</label>
                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
            </div>
            <div class="col-md-3 d-flex align-items-end gap-2">
                <button type="submit" class="btn btn-primary"><i class="fas fa-filter me-1"></i>Filter</button>
                <a href="{{ route('admin.activity-log') }}" class="btn btn-secondary">Clear</a>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th width="50">#</th>
                        <th>User</th>
                        <th>Action</th>
                        <th>Description</th>
                        <th>Details</th>
                        <th>IP Address</th>
                        <th>Date/Time</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr>
                        <td>{{ $logs->firstItem() + $loop->index }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2" style="width:32px;height:32px;">
                                    <i class="fas fa-user text-primary small"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold small">{{ $log->user->name ?? 'System' }}</div>
                                    <small class="text-muted">{{ ucfirst($log->user->role ?? 'N/A') }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            @php
                                $badgeClass = match($log->action) {
                                    'created' => 'bg-success',
                                    'updated' => 'bg-warning text-dark',
                                    'deleted' => 'bg-danger',
                                    'viewed' => 'bg-info',
                                    'logged_in' => 'bg-primary',
                                    default => 'bg-secondary'
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ ucfirst(str_replace('_', ' ', $log->action)) }}</span>
                        </td>
                        <td class="small">{{ $log->description }}</td>
                        <td>
                            @if($log->old_values || $log->new_values)
                                <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#detailModal{{ $log->id }}">
                                    <i class="fas fa-eye"></i>
                                </button>

                                <div class="modal fade" id="detailModal{{ $log->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h6 class="modal-title">Activity Details</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                @if($log->old_values)
                                                    <h6 class="text-danger">Old Values</h6>
                                                    <pre class="bg-light p-3 rounded small">{{ json_encode($log->old_values, JSON_PRETTY_PRINT) }}</pre>
                                                @endif
                                                @if($log->new_values)
                                                    <h6 class="text-success">New Values</h6>
                                                    <pre class="bg-light p-3 rounded small">{{ json_encode($log->new_values, JSON_PRETTY_PRINT) }}</pre>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td><small class="text-muted">{{ $log->ip_address ?? 'N/A' }}</small></td>
                        <td><small class="text-muted">{{ $log->created_at->diffForHumans() }}<br>{{ $log->created_at->format('M d, Y H:i:s') }}</small></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            <i class="fas fa-history fa-2x mb-2 d-block"></i>
                            No activity logs found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="mt-3">{{ $logs->links() }}</div>
@endsection
