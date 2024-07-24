<?php
namespace App\Services;

use App\Models\Post;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use PDOException;

class PostService {

    public function __construct(private Post $post){}

    public function create(array $data): Post {
        try {
            return $this->post->create($data);
        } catch (PDOException $e) {
            Log::error($e->getMessage());
            throw $this->databaseException();
        }
    }

    public function getAll(): Collection {
        try {
            return $this->post->all();
        } catch (PDOException $e) {
            Log::error($e->getMessage());
            throw $this->databaseException();
        }
    }

    public function getById(int $id): ?Post {
        try {
            $post = $this->post->with("likes", "comments")->find($id);
            if ($post == null) {
                $this->invalidException();
            }
            return $post;
        } catch (PDOException $e) {
            $this->databaseException();
        }
    }

    public function update(int $id, array $data): Post {
        try {
            $post = $this->validatePost($id);
            $post->update($data);
            return $post;
        } catch (PDOException $e) {
            Log::error($e->getMessage());
            throw $this->databaseException();
        }
    }

    public function delete(int $id): void {
        try {
            $post = $this->validatePost($id);
            $post->delete();
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
                'message' => 'Post not found.'
            ], 404)
        );
    }

    private function validatePost(int $id): Post {
        $post = $this->post->find($id);
        if (!$post) {
            throw $this->invalidException();
        }
        return $post;
    }
}