<?php

namespace App\Services;

use App\Models\Post;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Storage;

/**
 *
 */
class PostTagService
{
    /**
     * @return mixed
     */
    public function index()
    {
        return Post::whereAuthorId(auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate();
    }

    /**
     * @param PostRequest $request
     * @return mixed
     */
    public function store(PostRequest $request)
    {
        $image = $this->storeImage($request);
        return Post::create(array_merge($request->all(), [
            'author_id' => auth()->id(),
            'image' => $image,
        ]));
    }

    /**
     * @param PostRequest $request
     * @param Post $post
     * @return Post
     */
    public function update(PostRequest $request, Post $post)
    {
        $image = $this->storeImage($request, $post->image);
        $post->update(array_merge($request->all(), [
            'author_id' => auth()->id(),
            'image' => $image,
        ]));

        return $post;
    }

    /**
     * @param Post $post
     * @return void
     */
    public function destroy(Post $post)
    {
        $post->delete();
    }

    private function storeImage(PostRequest $request, $image = null)
    {
        if ($request->hasFile('image')) {
            $image = Storage::disk('public')
                ->put('posts', $request->file('image'));
        }

        return $image;
    }
}
