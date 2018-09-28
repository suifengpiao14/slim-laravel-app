<?php

namespace App\Handlers;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Renders\ApiView;

/**
 * Api not allowed handler.
 *
 * It outputs a simple message in either JSON or XML.
 */
class ApiInvalidArgument extends ApiAbstractHandler
{
    protected $textPlain;

    public function __construct(ApiView $view, $textPlain = false)
    {
        parent::__construct($view);
        $this->textPlain = $textPlain;
    }

    /**
     * Invoke error handler.
     *
     * @param ServerRequestInterface $request  The most recent Request object
     * @param ResponseInterface      $response The most recent Response object
     * @param string[]               $methods  Allowed HTTP methods
     *
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, \InvalidArgumentException $exception)
    {
        $exceptionCode = $exception->getCode();
        $status = 400;
        if (in_array($exceptionCode, [401, 402, 405])) {
            $status = $exceptionCode;
        }

        $data = [
            'message' => $exception->getMessage(),
            'status_code' => $exceptionCode,
        ];

        return $this->view->render($request, $response, $data, $status);
    }
}
