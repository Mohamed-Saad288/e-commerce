<?php

namespace App\Modules\Organization\app\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use App\Modules\Organization\app\DTO\Question\QuestionDto;
use App\Modules\Organization\app\Http\Request\Question\StoreQuestionRequest;
use App\Modules\Organization\app\Http\Request\Question\UpdateQuestionRequest;
use App\Modules\Organization\app\Models\Question\Question;
use App\Modules\Organization\app\Services\Question\QuestionService;
use Exception;

class QuestionController extends Controller
{
    public function __construct(protected QuestionService $service){}

    public function index()
    {
        $questions = $this->service->index();
        return view('organization::dashboard.questions.index', get_defined_vars());
    }
    public function create()
    {
        return view('organization::dashboard.questions.single',get_defined_vars());
    }
    public function store(StoreQuestionRequest $request)
    {
         $this->service->store(QuestionDto::fromArray($request));
        return to_route('organization.questions.index')->with(array(
            'message' => __("messages.success"),
            'alert-type' => 'success'
        ));
    }
    public function edit(Question $question)
    {
        return view('organization::dashboard.questions.single', get_defined_vars());
    }
    public function update(UpdateQuestionRequest $request , Question $question)
    {
        $this->service->update(model: $question, dto: QuestionDto::fromArray($request));

        return to_route('organization.questions.index')->with(array(
            'message' => __("messages.updated"),
            'alert-type' => 'success'
        ));
    }
    public function destroy(Question $question)
    {
        try {
            $this->service->delete(model: $question);
            return response()->json([
                'success' => true,
                'message' => __('messages.deleted')
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('messages.something_wrong')
            ], 500);
        }
    }


}
