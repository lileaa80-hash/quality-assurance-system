<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// <?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Log;

// class EvaluationQuestionController extends Controller
// {
//     public function index(Request $request)
//     {
//         $questionnaireId = $request->query('questionnaire_id');

//         if (!$questionnaireId) {
//             return redirect()->route('evaluation_questionnaires.index')->with('error', 'Kuesioner tidak ditentukan.');
//         }

//         $questionnaire = DB::table('evaluation_questionnaires')->where('id', $questionnaireId)->first();
        
//         $questions = DB::table('evaluation_questions')
//             ->where('questionnaire_id', $questionnaireId)
//             ->orderBy('order', 'asc')
//             ->get();

//         return view('evaluation_questions.index', compact('questions', 'questionnaire'));
//     }

//     public function create(Request $request)
//     {
//         $questionnaireId = $request->query('questionnaire_id');
//         $questionnaire = DB::table('evaluation_questionnaires')->where('id', $questionnaireId)->first();

//         if (!$questionnaire) {
//             return redirect()->route('evaluation_questionnaires.index')->with('error', 'Kuesioner tidak ditemukan.');
//         }

//         return view('evaluation_questions.create', compact('questionnaire'));
//     }

//     public function store(Request $request)
//     {
//         $request->validate([
//             'questionnaire_id' => 'required',
//             'question_text' => 'required',
//             'type' => 'required',
//             'section' => 'required',
//         ]);

//         try {
//             DB::table('evaluation_questions')->insert([
//                 'questionnaire_id' => $request->questionnaire_id,
//                 'section' => $request->section,
//                 'question_text' => $request->question_text,
//                 'type' => $request->type,
//                 // Encode ke JSON karena kita pakai DB table manual
//                 'options' => $request->options ? json_encode($request->options) : null,
//                 'scale_labels' => $request->scale_labels ? json_encode($request->scale_labels) : null,
//                 'is_required' => $request->has('is_required') ? 1 : 0,
//                 'weight' => $request->weight ?? 1,
//                 'order' => $request->order ?? 0,
//                 'created_at' => now(),
//                 'updated_at' => now(),
//             ]);

//             // Kembali ke halaman show kuesioner agar admin bisa tambah lagi dengan cepat
//             return redirect()->route('evaluation_questionnaires.show', $request->questionnaire_id)
//                              ->with('success', 'Pertanyaan Berhasil Ditambahkan!');
                             
//         } catch (\Exception $e) {
//             Log::error('Error Store Question: ' . $e->getMessage());
//             return back()->with('error', 'Gagal: ' . $e->getMessage());
//         }
//     }

//     public function edit($id)
//     {
//         $question = DB::table('evaluation_questions')->where('id', $id)->first();

//         if (!$question) {
//             return back()->with('error', 'Pertanyaan tidak ditemukan.');
//         }

//         // Decode JSON agar bisa dibaca di Blade
//         $question->options = json_decode($question->options, true);
//         $question->scale_labels = json_decode($question->scale_labels, true);

//         $questionnaire = DB::table('evaluation_questionnaires')->where('id', $question->questionnaire_id)->first();

//         return view('evaluation_questions.edit', compact('question', 'questionnaire'));
//     }

//     public function update(Request $request, $id)
//     {
//         $request->validate([
//             'question_text' => 'required',
//             'type' => 'required',
//             'section' => 'required',
//         ]);

//         try {
//             $question = DB::table('evaluation_questions')->where('id', $id)->first();

//             DB::table('evaluation_questions')
//                 ->where('id', $id)
//                 ->update([
//                     'section' => $request->section,
//                     'question_text' => $request->question_text,
//                     'type' => $request->type,
//                     'options' => $request->options ? json_encode($request->options) : null,
//                     'scale_labels' => $request->scale_labels ? json_encode($request->scale_labels) : null,
//                     'is_required' => $request->has('is_required') ? 1 : 0,
//                     'weight' => $request->weight ?? 1,
//                     'order' => $request->order ?? 0,
//                     'updated_at' => now(),
//                 ]);

//             return redirect()->route('evaluation_questionnaires.show', $question->questionnaire_id)
//                              ->with('success', 'Pertanyaan Berhasil Diperbarui!');

//         } catch (\Exception $e) {
//             return back()->with('error', 'Gagal: ' . $e->getMessage());
//         }
//     }

//     public function destroy($id)
//     {
//         $question = DB::table('evaluation_questions')->where('id', $id)->first();
//         $qid = $question->questionnaire_id;

//         DB::table('evaluation_questions')->where('id', $id)->delete();

//         return redirect()->route('evaluation_questionnaires.show', $qid)
//                          ->with('success', 'Pertanyaan Berhasil Dihapus!');
//     }
// }