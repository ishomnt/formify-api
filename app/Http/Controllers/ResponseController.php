<?php

namespace App\Http\Controllers;

use App\Http\Resources\ResponseResource;
use Carbon\Carbon;
use App\Models\Form;
use App\Models\Answer;
use App\Models\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ResponseRequest;
use Illuminate\Validation\ValidationException;

class ResponseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $response = Response::with(['user', 'answers', 'answers.question'])->paginate()->toResourceCollection();
            return $this->responseWithSuccess($response);
        } catch (\Exception $e) {
            return $this->responseWithError('Unknown error', 500, $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(string $slug, ResponseRequest $request)
    {
        DB::beginTransaction();
        try {
            $form = Form::where("slug", $slug)->first();
            $response = Response::where('user_id', Auth::user()->id)->where('form_id', $form->id)->first();
            if ($response) {
                return $this->responseWithError('You can not submit form twice', 422);
            }
            $response = Response::create([
                'form_id' => $form->id,
                'user_id' => Auth::user()->id,
                'date' => Carbon::now(),
            ]);

            foreach ($request->answers as $value) {
                Answer::create([
                    'response_id' => $response->id,
                    'question_id'=> $value['question_id'],
                    'value' => $value['value'],
                ]);
            }

            DB::commit();
            return $this->responseWithSuccess(null, 'Submit response success');
        } catch (ValidationException $ve) {
            DB::rollback();
            return $this->responseWithError('Invalid field', 422, $ve->validator->errors());
        } catch (\Exception $e) {
            DB::rollback();
            return $this->responseWithError('Unknown error', 500, $e->getMessage());
        }
    }
}
