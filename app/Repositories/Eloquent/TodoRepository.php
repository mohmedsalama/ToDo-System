<?php

namespace App\Repositories\Eloquent;

use App\Models\Todo;
use App\Repositories\Contracts\TodoRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class TodoRepository implements TodoRepositoryInterface
{
    public function paginate(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $query = Todo::query();

        // Optional search by title
        if (!empty($filters['search'])) {
            $query->where('title', 'like', '%' . $filters['search'] . '%');
        }

        // Optional filter by status
        if (!empty($filters['status'])) {
            if ($filters['status'] === 'completed') {
                $query->where('is_completed', true);
            } elseif ($filters['status'] === 'pending') {
                $query->where('is_completed', false);
            }
        }
        // because the user_id column was manually removed from the migration earlier.

        return $query->latest()->paginate($perPage);
    }

    public function findById(int $id): ?Todo
    {
        return Todo::find($id);
    }

    public function create(array $data): Todo
    {
        // Unset user_id to prevent fillable/SQL errors due to manual column removal
        unset($data['user_id']);
        
        return Todo::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $todo = $this->findById($id);
        if (!$todo) return false;

        unset($data['user_id']);
        return $todo->update($data);
    }

    public function delete(int $id): bool
    {
        $todo = $this->findById($id);
        if (!$todo) return false;

        return $todo->delete();
    }
}
