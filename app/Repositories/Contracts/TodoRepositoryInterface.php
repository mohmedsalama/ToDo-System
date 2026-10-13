<?php

namespace App\Repositories\Contracts;

use App\Models\Todo;
use Illuminate\Pagination\LengthAwarePaginator;

interface TodoRepositoryInterface
{
    /**
     * Get paginated todos with optional search filters.
     *
     * @param int $perPage
     * @param array<string, mixed> $filters
     * @return LengthAwarePaginator<Todo>
     */
    public function paginate(int $perPage = 15, array $filters = []): LengthAwarePaginator;

    /**
     * Find a single todo by its ID.
     *
     * @param int $id
     * @return Todo|null
     */
    public function findById(int $id): ?Todo;

    /**
     * Create a new todo item.
     *
     * @param array<string, mixed> $data
     * @return Todo
     */
    public function create(array $data): Todo;

    /**
     * Update an existing todo item.
     *
     * @param int $id
     * @param array<string, mixed> $data
     * @return bool
     */
    public function update(int $id, array $data): bool;

    /**
     * Delete a todo item.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
}
