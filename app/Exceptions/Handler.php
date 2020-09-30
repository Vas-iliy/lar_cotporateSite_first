<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Throwable
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($this->isHttpException($exception)) {
            $status = $exception->getStatusCode();
            switch ($status) {
                case '404':
                    $obj = new \App\Http\Controllers\SiteController(new \App\Repositories\MenusRepository(new \App\Menu));
                    $navigation = view(env('THEME') . '.navigation')->with('menu', $obj->getMenu())->render();

                    Log::alert('Страница не найдена - ' . $request->url());

                    return response()->view(env('THEME') . '.404', ['bar' => 'no', 'title' => 'Страница не найдена', 'navigation' => $navigation]);
            }
        }
        return parent::render($request, $exception);
    }
}
