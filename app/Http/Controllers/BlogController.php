<?php

namespace App\Http\Controllers;

use App\Services\BlogService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function __construct(private BlogService $blogService) {}

    public function index(): JsonResponse
    {
        $blogs = $this->blogService->getAll();
        return response()->json(['status' => true, 'data' => $blogs]);
    }

    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'cover_image_url' => 'required|url',
        ]);

        $blog = $this->blogService->create($validatedData);
        return response()->json(['status' => true, 'data' => $blog], 201);
    }

    public function show($id): JsonResponse
    {
        $id = (int) $id;
        $blog = $this->blogService->getById($id);
        return response()->json(['status' => true, 'data' => $blog]);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $id = (int) $id;
        $validatedData = $request->validate([
            'title' => 'string|max:255',
            'description' => 'string',
            'cover_image_url' => 'url',
        ]);

        $blog = $this->blogService->update($id, $validatedData);
        return response()->json(['status' => true, 'data' => $blog]);
    }

    public function destroy($id): JsonResponse
    {
        $id = (int) $id;
        $this->blogService->delete($id);
        return response()->json(['status' => true, 'message' => 'Blog deleted successfully']);
    }
}

