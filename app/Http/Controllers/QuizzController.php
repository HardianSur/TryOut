<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class QuizzController extends Controller
{

    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('app.base_api');
    }

    protected function getToken()
    {
        return session('access_token');
    }

    private function storeAnswer($questionId, $answerId)
    {
        $answers = session('quiz_answers', []);
        $answers[$questionId] = $answerId;
        session(['quiz_answers' => $answers]);
        return;
    }


    public function get($endpoint, $params = [])
    {
        $token = $this->getToken();

        $response = Http::withToken($token)
            ->get($this->baseUrl . '/' . $endpoint, $params);

        return $response->json();
    }

    public function index(Request $request)
    {
        $count = count($this->get('tryout/question')['data']);

        if ($request->input('question_id') && $request->input('answer_id')) {
            $this->storeAnswer($request->input('question_id'), $request->input('answer_id'));
        }

        $page = $request->input('page') ?? 1;
        $data = $this->get("tryout/question/$page")['data'];
        return view('quiz.index', compact('data', 'count'));
    }

    public function calculateScore(Request $request)
    {
        $this->storeAnswer($request->post('question_id'), $request->post('answer_id'));

        $questions = $this->get('tryout/question')['data'];
        $answers = session('quiz_answers', []);
        $totalScore = 0;

        foreach ($questions as $question) {
            $questionId = $question['id'];
            if (isset($answers[$questionId])) {
                $selectedOptionId = $answers[$questionId];
                foreach ($question['tryout_question_option'] as $option) {
                    if ($option['id'] == $selectedOptionId) {
                        $totalScore += $option['nilai'];
                        break;
                    }
                }
            }
        }

        session()->forget('quiz_answers');

        return view('quiz.result', compact('totalScore'));
    }
}
