<?php

namespace Shopper\Framework\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class ShopperExceptionHandler extends ExceptionHandler
{
    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $e
     *
     * @return void
     *
     * @throws \Throwable
     */
    public function report(Throwable $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $e)
    {
        if (! $request->user() && ! $request->user()->hasRole(config('shopper.system.users.admin_role'))) {
            return parent::render($request, $e);
        }

        return response()->view(
            'shopper::errors.template',
            ['exception' => $e]
        );
    }
}
