<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AllowedDomainMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $slug = $request->route("slug");
        $form = Form::with(relations: ['allowedDomains', 'questions'])->where('slug', $slug)->first();
        if (!$form) {
            return response()->json([
                'message' => 'Form not found'
            ], 404);
        }
        $domain = explode('@', Auth::user()->email);
        foreach ($form->allowedDomains as $value) {
            if ($value->domain != $domain[1]) {
                return response()->json([
                    'message' => 'Forbidden access'
                ], 403);
            }
        }
        return $next($request);
    }
}
