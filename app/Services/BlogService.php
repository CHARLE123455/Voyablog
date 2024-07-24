<?php

namespace App\Services;

use App\Models\Blog;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use PDOException;

class BlogService {
    public function __construct(private Blog $blog) {}

    public function create(array $blog): Blog {
        try {
            return $this->blog->create($blog);
        } catch (PDOException $e) {
            Log::error($e->getMessage());
            throw $this->databaseException();
        }
    }

    public function getAll(): Collection {
        try {
            return $this->blog->all();
        } catch (PDOException $e) {
            Log::error($e->getMessage());
            throw $this->databaseException();
        }
    }

    public function getById($id): ?Blog
{
    $id = (int) $id;
    try {
        $blog = $this->blog->find($id);
        if (!$blog) {
            throw $this->invalidException();
        }
        return $blog;
    } catch (PDOException $e) {
        Log::error($e->getMessage());
        throw $this->databaseException();
    }
}

public function update($id, array $data): Blog
{
    $id = (int) $id;
    try {
        $blog = $this->blog->find($id);
        if (!$blog) {
            throw $this->invalidException();
        }
        $validatedData = Validator::make($data, [
            'title' => 'string|max:255',
            'description' => 'string',
            'cover_image_url' => 'url',
        ])->validate();
        $blog->update($validatedData);
        return $blog;
    } catch (PDOException $e) {
        Log::error($e->getMessage());
        throw $this->databaseException();
    }
}

public function delete($id): void
{
    $id = (int) $id;
    try {
        $blog = $this->blog->find($id);
        if (!$blog) {
            throw $this->invalidException();
        }
        $blog->delete();
    } catch (PDOException $e) {
        Log::error($e->getMessage());
        throw $this->databaseException();
    }
}

    private function databaseException(): HttpResponseException {
        return new HttpResponseException(
            response()->json([
                'status' => false,
                'message' => 'Internal server error. Kindly try again later.'
            ], 500)
        );
    }

    private function invalidException(): HttpResponseException {
        return new HttpResponseException(
            response()->json([
                'status' => false,
                'message' => 'Blog does not exist.'
            ], 404)
        );
    }
}