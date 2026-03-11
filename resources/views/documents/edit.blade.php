@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header text-white py-3" style="background-color: #ffc107;">
                    <h5 class="mb-0 font-weight-bold text-dark">Edit Dokumen: {{ $document->document_number }}</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('documents.update', $document->id) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="row border-bottom mb-3 pb-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold">Nomor Dokumen</label>
                                <input type="text" name="document_number" value="{{ $document->document_number }}" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold">Status Dokumen</label>
                                <select name="status" class="form-control">
                                    <option value="draft" {{ $document->status == 'draft' ? 'selected' : '' }}>DRAFT</option>
                                    <option value="review" {{ $document->status == 'review' ? 'selected' : '' }}>REVIEW</option>
                                    <option value="published" {{ $document->status == 'published' ? 'selected' : '' }}>PUBLISHED</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Judul Dokumen</label>
                            <input type="text" name="title" value="{{ $document->title }}" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Keterangan</label>
                            <textarea name="description" class="form-control" rows="3">{{ $document->description }}</textarea>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('documents.index') }}" class="btn btn-light border">Kembali</a>
                            <button type="submit" class="btn btn-warning px-4 text-white">Update Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection