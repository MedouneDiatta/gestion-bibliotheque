<?php
declare(strict_types=1);

namespace App\Exception;

final class ValidationException extends BiblioTechException
{
    private array $errors;

    public function __construct(array $errors, string $message = "Erreur de validation des données.", int $code = 422, ?\Throwable $previous = null)
    {
        $this->errors = $errors;
        parent::__construct($message, $code, $previous);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}