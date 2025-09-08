<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;
use App\Models\AllowedDomain;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\FormResource;
use App\Http\Requests\FormRequest;
use Illuminate\Validation\ValidationException;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $form = Form::paginate(10);
            return $this->responseWithSuccess(FormResource::collection($form), 'Get all forms success', 'form');
        } catch (ValidationException $th) {
            return $this->responseWithError($th->validator->errors());
        } catch (\Exception $e) {
            return $this->responseWithError($e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FormRequest $request)
    {
        DB::beginTransaction();
        try {
            $form = Form::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'description' => $request->description,
                'limit_one_response' => $request->limit_one_response,
                'creator_id' => Auth::user()->id,
            ]);
            if ($request->allowed_domains){
                foreach ($request->allowed_domains as $domain) {
                    AllowedDomain::create([
                        'form_id'=> $form->id,
                        'domain' => $domain,
                    ]);
                }
            }
            $form = [...$request->all(), 'id' => $form->id];
            DB::commit();
            return $this->responseWithSuccess($form, 'Create form success', 'form');
        } catch (ValidationException $th) {
            DB::rollback();
            return $this->responseWithError('Invalid field', 422, $th->validator->errors());
        } catch (\Exception $e) {
            DB::rollback();
            return $this->responseWithError('Unknown error', 500, $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(String $slug)
    {
        try {
            $form = Form::with(relations: ['allowedDomains', 'questions'])->where('slug', $slug)->first();
            if (!$form){
                return $this->responseWithError('Form not found', 404, 'Not found');
            }
            $domain = explode('@', Auth::user()->email);
            foreach ($form->allowedDomains as $value) {
                if ($value->domain != $domain[1]) {
                    return $this->responseWithError('Forbidden access', 403, 'Forbidden');
                }
            }
            return $this->responseWithSuccess(new FormResource($form), "Get form success", 'form');
        } catch (\Exception $e) {
            return $this->responseWithError('Unknown error', 500, $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Form $form)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Form $form)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Form $form)
    {
        //
    }
}
