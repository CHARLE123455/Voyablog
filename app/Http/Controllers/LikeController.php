<?php

namespace App\Http\Controllers;

use App\Services\LikeService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class LikeController extends Controller
{
    public function __construct(private LikeService $likeService) {}
//like post
    public function store( $postId): JsonResponse
    {
        $like = $this->likeService->likePost($postId);
        return response()->json(['status' => true, 'data' => $like], 201);
    }
// unlike post
    public function destroy($likeId): JsonResponse
    {
        $this->likeService->unlikePost($likeId);
        return response()->json(['status' => true, 'message' => 'Post unliked successfully']);
    }
}
