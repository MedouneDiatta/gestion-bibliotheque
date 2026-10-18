<?php
declare(strict_types=1);

namespace App\Core;

use App\Exception\ValidationException;

final class Validator
{
    private array $errors = [];

    public function validate(array $data, array $rules): bool
    {
        foreach ($rules as $field => $ruleString) {
            $ruleList = explode('|', $ruleString);
            $value = $data[$field] ?? null;

            foreach ($ruleList as $rule) {
                // Règle "required"
                if ($rule === 'required') {
                    if ($value === null || trim((string)$value) === '') {
                        $this->addError($field, "Le champ {$field} est obligatoire.");
                        break; // Arrête les vérifications pour ce champ si vide
                    }
                }

                // Si le champ est vide et non requis, on passe aux champs suivants
                if (($value === null || trim((string)$value) === '') && $rule !== 'required') {
                    continue;
                }

                // Règle "email"
                if ($rule === 'email') {
                    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        $this->addError($field, "L'adresse e-mail n'est pas valide.");
                    }
                }

                // Règle "min:X"
                if (str_starts_with($rule, 'min:')) {
                    $min = (int)substr($rule, 4);
                    if (mb_strlen((string)$value) < $min) {
                        $this->addError($field, "Le champ {$field} doit contenir au moins {$min} caractères.");
                    }
                }

                // Règle "numeric"
                if ($rule === 'numeric') {
                    if (!is_numeric($value)) {
                        $this->addError($field, "Le champ {$field} doit être un nombre.");
                    }
                }
            }
        }

        if (!empty($this->errors)) {
            throw new ValidationException($this->errors);
        }

        return true;
    }

    private function addError(string $field, string $message): void
    {
        $this->errors[$field][] = $message;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}