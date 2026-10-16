<?php
declare(strict_types=1);

namespace App\Contract;

interface RepositoryInterface
{
    public function find(int $id): object;
    public function findAll(): array;
    public function save(object $entite): bool;
    public function delete(int $id): bool;
}