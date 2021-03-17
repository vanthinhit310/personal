<?php


namespace App\Handle;


use Illuminate\Support\Facades\Log;
use Platform\Base\Http\Responses\BaseHttpResponse;
use Symfony\Component\HttpFoundation\Response;

class ResponseHandle extends BaseHttpResponse
{
    public function internalServerResponse($exception, $class, $action): ResponseHandle
    {
        Log::error(sprintf('Error on %s@%s with trace %s', $class, $action, $exception));
        return $this->setError()
            ->setData(['system_message' => $exception->getMessage()])
            ->setMessage('The server encountered an internal error of misconfiuration and was unable to complete your request!')
            ->setCode(Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function notfoundResponse(): ResponseHandle
    {
        return $this->setError()
            ->setMessage('Date not exists!')
            ->setCode(Response::HTTP_NOT_FOUND);
    }

    public function unAuthorized(): ResponseHandle
    {
        return $this->setError()
            ->setMessage('You are not authorized! Please login and try again!')
            ->setCode(Response::HTTP_UNAUTHORIZED);
    }
}
