<?php

declare(strict_types=1);

namespace App\Exceptions\NYTimesBooks;

use Throwable;
use Exception;

abstract class ApiException extends Exception
{
    /**
     * @var int|null
     */
    protected ?int $statusCode;
    
    /**
     * @param string $message
     * @param int|null $statusCode
     * @param array|null $responseData
     * @param Throwable|null $previous
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
     * @return int|null
     */
    public function getStatusCode(): ?int
    {
        return $this->statusCode;
    }

    /**
     * @return array|null
     */
    public function getResponseData(): ?array
    {
        return $this->responseData;
    }

    /**
     * @return string
     */
    abstract public function getUserMessage(): string;

    /**
     * @return string
     */
    public function getTroubleshootingInfo(): string
    {
        return "Please check your request and try again.";
    }

    /**
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
