<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;
use PDOException;

class CommentService
{
    public function addCommentToPost($comment, $postId)
    {
        try {
            $post = Post::find($postId);
            if ($post) {
                return $post->comments()->create($comment);
            } else {
                $this->invalidPostException();
            }
        } catch (PDOException $e) {
            Log::error("Error adding comment to post: " . $e->getMessage());
            $this->databaseException();
        }
    }

    public function getAllCommentsByPostId($postId)
    {
        try {
            $post = Post::find($postId);
            if ($post) {
                return $post->comments;
            } else {
                $this->invalidPostException();
            }
        } catch (PDOException $e) {
            Log::error("Error retrieving comments for post: " . $e->getMessage());
            $this->databaseException();
        }
    }

    private function databaseException() {
        throw new HttpResponseException(
            response()->json([
                'status' => false,
                'message' => 'Internal server error. Please try again later.'
            ], 500)
        );
    }

    private function invalidPostException() {
        throw new HttpResponseException(
            response()->json([
                'status' => false,
                'message' => 'Invalid Post ID.'
            ], 400)
        );
    }
}
