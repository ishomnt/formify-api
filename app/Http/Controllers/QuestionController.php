<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\QuestionRequest;
use Illuminate\Validation\ValidationException;

class QuestionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(String $slug, QuestionRequest $request)
    {
        DB::beginTransaction();
        try {
            $form = Form::where("slug", $slug)->first();
            $question = Question::create([
                'form_id' => $form->id,
                'name' => $request->name,
                'choice_type' => $request->choice_type,
                'is_required' => $request->is_required
            ]);

            if($request->choice_type == 'multiple choice' || $request->choice_type == 'dropdown' || $request->choice_type == 'checkboxes') {
                $question->choices = json_encode($request->choices);
                $question->save();
            }

            $question = [...$request->all(), 'id' => $question->id];
            DB::commit();
            return $this->responseWithSuccess($question, 'Add question success', 'question');
        } catch (ValidationException $ve) {
            DB::rollback();
            return $this->responseWithError('Invalid field', 422, $ve->validator->errors());
        } catch (\Exception $e) {
            DB::rollback();
            return $this->responseWithError('Unknown error', 500, $e->getMessage());
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $slug, Question $question)
    {
        try {
            $question->delete();
            return $this->responseWithError('Remove question success', 200);
        } catch (\Exception $e) {
            return $this->responseWithError('Unknown error', 500, $e->getMessage());
        }
    }
}
