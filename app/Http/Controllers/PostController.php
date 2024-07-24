<?php

namespace App\Http\Controllers;

use App\Services\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct(private PostService $postService) {}

    public function index(): JsonResponse
    {
        $posts = $this->postService->getAll();
        return response()->json(['status' => true, 'data' => $posts]);
    }

    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'blog_id' => 'required|exists:blogs,id',
            'title' => 'required|string|max:255',
            'descripton' => 'required|string',
            'content' => 'required|string',
            'image_url' => 'nullable|url',
        ]);

        $post = $this->postService->create($validatedData);
        return response()->json(['status' => true, 'data' => $post], 201);
    }

    public function show( $id): JsonResponse
    {
        $post = $this->postService->getById($id);
        return response()->json(['status' => true, 'data' => $post]);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $validatedData = $request->validate([
            'title' => 'string|max:255',
            'content' => 'string',
            'descripton' => 'string',
            'cover_image_url' => 'nullable|url',
        ]);

        $post = $this->postService->update($id, $validatedData);
        return response()->json(['status' => true, 'data' => $post]);
    }

    public function destroy($id): JsonResponse
    {
        $this->postService->delete($id);
        return response()->json(['status' => true, 'message' => 'Post deleted successfully']);
    }
}
