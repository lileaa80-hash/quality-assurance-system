@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Detail Dokumen</h4>
                    <a href="{{ route('documents.index') }}" class="btn btn-light btn-sm">Kembali</a>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">No. Dokumen</th>
                            <td>{{ $document->document_number }}</td>
                        </tr>
                        <tr>
                            <th>Judul</th>
                            <td>{{ $document->title }}</td>
                        </tr>
                        <tr>
                            <th>Jenis</th>
                            <td><span class="badge bg-secondary">{{ $document->type }}</span></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td><span class="badge bg-warning text-dark">{{ strtoupper($document->status) }}</span></td>
                        </tr>
                        <tr>
                            <th>Pembuat</th>
                            <td>{{ $document->creator_name ?? 'Tidak diketahui' }}</td>
                        </tr>
                        <tr>
                            <th>Deskripsi</th>
                            <td>{{ $document->description ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Dibuat</th>
                            <td>{{ \Carbon\Carbon::parse($document->created_at)->format('d M Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
                <div class="card-footer text-end">
                    <a href="{{ route('documents.edit', $document->id) }}" class="btn btn-warning">Edit Data</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection