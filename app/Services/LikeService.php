<?php

namespace App\Services;

use App\Models\Post;
use App\Models\Like;
use App\Models\User;
use App\Exceptions\InvalidPostException;
use App\Exceptions\InvalidUserException;
use App\Exceptions\LikeAlreadyExistsException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;
use PDOException;

class LikeService {

    public function likePost(int $postId) {
        try {
            $post = Post::find($postId);

            if (!$post) {
                throw new InvalidPostException('Invalid Post ID.');
            }

            $user = User::find(auth()->id());

            if (!$user) {
                throw new InvalidUserException('Invalid User.');
            }

            // Check if the user has already liked the post
            $existingLike = Like::where('post_id', $postId)->where('user_id', $user->id)->first();
            if ($existingLike) {
                throw new LikeAlreadyExistsException('User has already liked this post.');
            }

            $like = $post->likes()->create([
                'user_id' => $user->id
            ]);

            return $like;
        } catch (PDOException $e) {
            Log::error('Error liking post: ' . $e->getMessage());
            throw $this->databaseException();
        }
    }

    public function unlikePost(int $likeId) {
        try {
            $like = Like::find($likeId);

            if (!$like) {
                throw new InvalidPostException('Invalid Like ID.');
            }

            $like->delete();

            return true;
        } catch (PDOException $e) {
            Log::error('Error unliking post: ' . $e->getMessage());
            throw $this->databaseException();
        }
    }

    private function databaseException(): HttpResponseException {
        return new HttpResponseException(
            response()->json([
                'status' => false,
                'message' => 'Internal server error. Please try again later.'
            ], 500)
        );
    }
}
