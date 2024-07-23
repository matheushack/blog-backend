<?php

namespace App\Services;

use App\Models\Post;
use App\Http\Requests\PostRequest;
use App\Models\PostComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 *
 */
class PostService
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        return Post::query()
            ->when(!$request->input('withoutFilterUser', false), function ($query) {
                $query->whereAuthorId(auth()->id());
            })
            ->orderBy($request->input('sort.0.key', 'created_at'), $request->input('sort.0.order', 'desc'))
            ->paginate($request->input('per_page', 10));
    }

    /**
     * @param PostRequest $request
     * @return mixed
     */
    public function store(PostRequest $request)
    {
        DB::transaction(function () use ($request, &$post) {
            $image = $this->storeImage($request);
            $post = Post::create(array_merge($request->except('tags'), [
                'author_id' => auth()->id(),
                'image' => $image,
            ]));

            if ($post && $request->input('tags')) {
                $post->tags()->createMany($this->makeTags($request->input('tags')));
            }
        });

        return $post;
    }

    /**
     * @param Request $request
     * @param Post $post
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function storeComment(Request $request, Post $post)
    {
        $post->comments()->create([
            'name' => $request->input('name'),
            'comment' => $request->input('comment'),
        ]);

        return $post->comments()
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * @param PostRequest $request
     * @param Post $post
     * @return Post
     */
    public function update(PostRequest $request, Post $post)
    {
        DB::transaction(function () use ($request, &$post) {
            $image = $this->storeImage($request, $post->image);
            $post->update(array_merge($request->all(), [
                'author_id' => auth()->id(),
                'image' => $image,
            ]));

            if ($post && $request->input('tags')) {
                $post->tags()->delete();
                $post->tags()->createMany($request->input('tags'));
            }
        });

        return $post;
    }

    /**
     * @param Post $post
     * @return void
     */
    public function destroy(Post $post)
    {
        DB::transaction(function () use ($post) {
            $post->tags()->delete();
            $post->comments()->delete();
            $post->delete();
        });
    }

    /**
     * @param PostComment $comment
     * @return void
     */
    public function destroyComment(PostComment $comment)
    {
        $comment->delete();
    }

    /**
     * @param PostRequest $request
     * @param $image
     * @return bool|mixed|null
     */
    private function storeImage(PostRequest $request, $image = null)
    {
        if ($request->hasFile('image')) {
            $image = Storage::disk('public')
                ->put('posts', $request->file('image'));
        }

        return $image;
    }

    /**
     * @param $tags
     * @return mixed[]
     */
    private function makeTags($tags)
    {
        return collect($tags)
            ->transform(function ($tag) {
                return [
                    'tag' => $tag
                ];
            })->toArray();
    }
}
