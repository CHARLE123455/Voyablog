<?php

namespace App\Http\Controllers;

use App\Services\CommentService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
    public function __construct(private CommentService $commentService) {}

    public function store(Request $request, int $postId): JsonResponse
    {
        $validatedData = $request->validate([
            'content' => 'required|string',
        ]);

        $validatedData['user_id'] = auth()->id();
        $comment = $this->commentService->addCommentToPost($validatedData, $postId);
        return response()->json(['status' => true, 'data' => $comment], 201);
    }

    public function index(int $postId): JsonResponse
    {
        $comments = $this->commentService->getAllCommentsByPostId($postId);
        return response()->json(['status' => true, 'data' => $comments]);
    }
}