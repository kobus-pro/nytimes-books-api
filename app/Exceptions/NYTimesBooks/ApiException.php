<?php

declare(strict_types=1);

namespace App\Exceptions\NYTimesBooks;

use Throwable;
use Exception;

abstract class ApiException extends Exception
{
    /**
     * @var int|null The HTTP status code
     */
    protected ?int $statusCode;
    
    /**
     * Create a new API exception instance.
     *
     * @param string $message The exception message
     * @param int|null $statusCode The HTTP status code
     * @param array|null $responseData The response data from the API
     * @param Throwable|null $previous Previous exception if applicable
     */
    public function __construct(
        string $message,
        ?int $statusCode = null,
        protected ?array $responseData = null,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $statusCode ?? 0, $previous);
        
        $this->statusCode = $statusCode;
    }

    /**
     * Get the HTTP status code.
     *
     * @return int|null
     */
    public function getStatusCode(): ?int
    {
        return $this->statusCode;
    }

    /**
     * Get the response data.
     *
     * @return array|null
     */
    public function getResponseData(): ?array
    {
        return $this->responseData;
    }

    /**
     * Get a user-friendly error message
     *
     * @return string
     */
    abstract public function getUserMessage(): string;

    /**
     * Get troubleshooting information to help resolve the issue
     *
     * @return string
     */
    public function getTroubleshootingInfo(): string
    {
        return "Please check your request and try again.";
    }

    /**
     * Get detailed error information for developers
     * 
     * @return array
     */
    public function getDetailedErrorInfo(): array
    {
        return [
            'error_code' => $this->getCode(),
            'error_message' => $this->getMessage(),
            'troubleshooting' => $this->getTroubleshootingInfo()
        ];
    }
}
