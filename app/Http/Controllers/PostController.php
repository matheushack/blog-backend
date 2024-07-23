<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostCommentResource;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\PostComment;
use App\Services\PostService;
use Illuminate\Http\Request;

/**
 *
 */
class PostController extends Controller
{
    /**
     * @param PostService $service
     */
    public function __construct(protected PostService $service)
    {
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $response = $this->service->index($request);
        return PostResource::collection($response);
    }

    /**
     * @param Post $post
     * @return PostResource
     */
    public function show(Post $post)
    {
        return new PostResource($post);
    }

    /**
     * @param PostRequest $request
     * @return PostResource
     */
    public function store(PostRequest $request)
    {
        $response = $this->service->store($request);
        return new PostResource($response);
    }

    /**
     * @param Request $request
     * @param Post $post
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function storeComment(Request $request, Post $post)
    {
        $response = $this->service->storeComment($request, $post);
        return PostCommentResource::collection($response);
    }

    /**
     * @param PostRequest $request
     * @param Post $post
     * @return PostResource
     */
    public function update(PostRequest $request, Post $post)
    {
        $response = $this->service->update($request, $post);
        return new PostResource($response);
    }

    /**
     * @param Post $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Post $post)
    {
        $this->service->destroy($post);
        return response()
            ->json([
                'success' => true,
                'message' => 'Publicação deletada'
            ]);
    }

    /**
     * @param PostComment $comment
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyComment(PostComment $comment)
    {
        $this->service->destroyComment($comment);
        return response()
            ->json([
                'success' => true,
                'message' => 'Comentário deletado'
            ]);
    }
}
