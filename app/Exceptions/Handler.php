<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (TokenMismatchException $e, $request) {
            if ($request->is('login') || $request->is('admin/login') || $request->is('admin/*')) {
                return redirect()->route('admin.login')->with('alert', 'તમારું લૉગિન સત્ર સમાપ્ત થઈ ગયું હતું (Session Expired). કૃપા કરીને ફરીથી યુઝરનેમ અને પાસવર્ડ દાખલ કરો.');
            }

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['status' => 'error', 'message' => 'Your session expired. Please refresh the page and try again.'], 419);
            }

            return redirect()->back()
                ->withInput($request->except('password', 'current_password', '_token'))
                ->with('error', 'તમારું સત્ર સમાપ્ત થઈ ગયું હતું. કૃપા કરીને ફોર્મ ફરીથી સબમિટ કરો.');
        });
    }
}
