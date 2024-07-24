<?php
namespace App\Services;

use App\Models\Blog;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use PDOException;

class BlogService {

    public function __construct(private Blog $blog){}

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

    public function getById(int $id): ?Blog {
        try {
            return $this->validateBlog($id);
        } catch (PDOException $e) {
            Log::error($e->getMessage());
            throw $this->databaseException();
        }
    }

    public function update(int $id, array $data): Blog {
        try {
            $blog = $this->validateBlog($id);
            $blog->update($data);
            return $blog;
        } catch (PDOException $e) {
            Log::error($e->getMessage());
            throw $this->databaseException();
        }
    }

    public function delete(int $id): void {
        try {
            $blog = $this->validateBlog($id);
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

    private function validateBlog(int $id): Blog {
        $blog = $this->blog->with('posts')->find($id);
        if (!$blog) {
            throw $this->invalidException();
        }
        return $blog;
    }
}
