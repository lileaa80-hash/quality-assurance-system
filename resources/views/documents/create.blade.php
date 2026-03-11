@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header text-white py-3" style="background-color: #007bff;">
                    <h5 class="mb-0 font-weight-bold">Registrasi Dokumen Baru</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('documents.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold">Nomor Dokumen</label>
                                <input type="text" name="document_number" class="form-control @error('document_number') is-invalid @enderror" placeholder="SOP/IT/001" required>
                                @error('document_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold">Jenis Dokumen</label>
                                <select name="type" class="form-control" required>
                                    <option value="sop">SOP</option>
                                    <option value="manual_mutu">Manual Mutu</option>
                                    <option value="formulir">Formulir</option>
                                    <option value="kebijakan">Kebijakan</option>
                                    <option value="laporan">Laporan</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Judul Dokumen</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Induk Dokumen (Optional)</label>
                            <select name="parent_id" class="form-control">
                                <option value="">-- Pilih Jika Ada --</option>
                                @foreach($parentDocs as $p)
                                    <option value="{{ $p->id }}">{{ $p->document_number }} - {{ $p->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Keterangan</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('documents.index') }}" class="btn btn-light border">Batal</a>
                            <button type="submit" class="btn btn-primary px-4">Simpan Dokumen</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection