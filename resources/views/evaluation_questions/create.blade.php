@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="max-width: 950px; margin: auto;">
        <div class="card-header bg-primary text-white py-2">
            <h6 class="mb-0 fw-bold">Add New Evaluation Question</h6>
        </div>

        <div class="card-body p-4">
            {{-- Alert untuk menampilkan error validasi --}}
            @if ($errors->any())
                <div class="alert alert-danger py-2 small shadow-sm mb-3 border-0">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('evaluation_questions.store') }}" method="POST">
                @csrf
                <input type="hidden" name="questionnaire_id" value="{{ $questionnaireId }}">
                
                <div class="mb-4">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">QUESTION CONTEXT</h6>
                    <div class="row g-3">
                        {{-- Section Name --}}
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted small mb-1">SECTION / CATEGORY</label>
                            <input type="text" name="section" class="form-control form-control-sm shadow-sm" placeholder="e.g., Kurikulum Pendidikan Tinggi" required>
                            <div class="form-text mt-1" style="font-size: 10px;">Grouping questions based on specific SPMI standards.</div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">CONTENT & INSTRUMENT DETAILS</h6>
                    <div class="row g-3">
                        {{-- Question Text --}}
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted small mb-1">QUESTION TEXT</label>
                            <textarea name="question_text" class="form-control form-control-sm shadow-sm" rows="3" placeholder="Enter the evaluation question here..." required>{{ old('question_text') }}</textarea>
                        </div>
                        
                        {{-- Answer Type Selection --}}
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small mb-1">ANSWER TYPE</label>
                            <select name="type" id="type_select" class="form-select form-select-sm shadow-sm" required>
                                <option value="likert_5" selected>Likert Scale (1 - 5)</option>
                                <option value="likert_4">Likert Scale (1 - 4)</option>
                                <option value="multiple_choice">Multiple Choice</option>
                                <option value="essay">Essay / Open Ended</option>
                            </select>
                        </div>

                        {{-- Weight --}}
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-muted small mb-1">WEIGHT</label>
                            <input type="number" name="weight" class="form-control form-control-sm shadow-sm" value="1" min="1">
                        </div>

                        {{-- Display Order --}}
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-muted small mb-1">DISPLAY ORDER</label>
                            <input type="number" name="order" class="form-control form-control-sm shadow-sm" value="0">
                        </div>
                    </div>
                </div>

                <div class="mb-2 d-none" id="options_section">
                    <h6 class="text-primary fw-bold small border-bottom pb-2 mb-3">MULTIPLE CHOICE OPTIONS</h6>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted small mb-1">OPTIONS (ONE PER LINE)</label>
                            <textarea name="options[]" class="form-control form-control-sm shadow-sm" rows="4" placeholder="Option A&#10;Option B&#10;Option C"></textarea>
                            <div class="form-text mt-1" style="font-size: 10px;">Only required if 'Multiple Choice' is selected above.</div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                    <a href="{{ route('evaluation_questions.index', $questionnaireId) }}" class="btn btn-light btn-sm px-3 fw-bold border">Cancel</a>
                    <button type="submit" class="btn btn-primary btn-sm px-3 fw-bold shadow-sm">Save Question</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Logic untuk menyembunyikan/menampilkan field options (identik dengan cara kerja dinamis)
    document.getElementById('type_select').addEventListener('change', function() {
        const optionsSection = document.getElementById('options_section');
        if (this.value === 'multiple_choice') {
            optionsSection.classList.remove('d-none');
        } else {
            optionsSection.classList.add('d-none');
        }
    });
</script>
@endsection