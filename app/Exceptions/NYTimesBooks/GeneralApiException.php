<?php

declare(strict_types=1);

namespace App\Exceptions\NYTimesBooks;

class GeneralApiException extends ApiException
{
    /**
     * @return string
     */
    public function getUserMessage(): string
    {
        return 'We encountered an issue while communicating with the New York Times Books API. Please try again later.';
    }

    /**
     * @return string
     */
    public function getTroubleshootingInfo(): string
    {
        return "Please check your request parameters and network connection, and ensure the API is available.";
    }
}