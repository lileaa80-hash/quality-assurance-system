@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header text-white py-3" style="background-color: #007bff;">
            <h5 class="mb-0 font-weight-bold">SPMI SYSTEM - Daftar Dokumen Mutu</h5>
        </div>
        
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">Manajemen Dokumen</h4>
                <a href="{{ route('documents.create') }}" class="btn btn-primary shadow-sm">+ Registrasi Dokumen</a>
            </div>

            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover border">
                    <thead class="table-light text-secondary">
                        <tr>
                            <th>No. Dokumen</th>
                            <th>Judul</th>
                            <th>Jenis</th>
                            <th>Status</th>
                            <th>Versi</th>
                            <th>Pembuat</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($documents as $doc)
                        <tr>
                            <td><span class="badge bg-secondary px-2">{{ $doc->document_number }}</span></td>
                            <td><strong>{{ $doc->title }}</strong></td>
                            <td><span class="text-uppercase small font-weight-bold">{{ $doc->type }}</span></td>
                            <td>
                                <span class="badge {{ $doc->status == 'published' ? 'bg-success' : ($doc->status == 'draft' ? 'bg-warning' : 'bg-info') }}">
                                    {{ strtoupper($doc->status) }}
                                </span>
                            </td>
                            <td>v{{ $doc->current_version }}</td>
                            <td>{{ $doc->creator_name ?? 'System' }}</td>
                            <td class="text-center">
                                <div class="btn-group gap-1">
                                    <a href="{{ route('documents.show', $doc->id) }}" class="btn btn-sm btn-info text-white">Lihat</a>
                                    <a href="{{ route('documents.edit', $doc->id) }}" class="btn btn-sm btn-warning text-white">Edit</a>
                                    <form action="{{ route('documents.destroy', $doc->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus dokumen ini?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">Belum ada dokumen terdaftar.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection