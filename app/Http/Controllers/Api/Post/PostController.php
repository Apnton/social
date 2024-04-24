<?php

namespace App\Http\Controllers\Api\Post;

use App\Actions\Post\GetAllPostsAction;
use App\Actions\Post\GetCommentsByPostIdAction;
use App\Actions\Post\GetFollowingPostsAction;
use App\Actions\Post\RepostAction;
use App\Actions\Post\StoreCommentAction;
use App\Actions\Post\ToggleLikeAction;
use App\Actions\Post\StoreAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\RepostRequest;
use App\Http\Requests\Post\StoreCommentRequest;
use App\Http\Requests\Post\StoreRequest;
use App\Http\Resources\Post\CommentResource;
use App\Http\Resources\Post\PostResource;
use App\Http\Resources\Post\PostWithAuthorResource;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    use ApiResponser;

    public function index(Request $request, GetAllPostsAction $action): array
    {
        return $this->paginate(PostResource::class, $action->execute($request->get('limit')));
    }

    public function store(StoreRequest $request, StoreAction $action): JsonResponse
    {
        return $this->successResponse(PostResource::make($action->execute($request->validated())));
    }

    public function getFollowingPosts(Request $request, GetFollowingPostsAction $action): array
    {
        return $this->paginate(PostWithAuthorResource::class, $action->execute($request->get('limit')));
    }

    public function toggleLike(int $postId, ToggleLikeAction $action): JsonResponse
    {
        return $this->successResponse(PostResource::make($action->execute($postId)));
    }

    public function repost(RepostRequest $request, RepostAction $action): JsonResponse
    {
        $action->execute($request->validated());
        return $this->emptyResponse();
    }

    public function storeComment(StoreCommentRequest $request, StoreCommentAction $action): JsonResponse
    {
        return $this->successResponse(CommentResource::make($action->execute($request->validated())));
    }

    public function getCommentsByPostId(int $postId, GetCommentsByPostIdAction $action): JsonResponse
    {
        return $this->successResponse(CommentResource::collection($action->execute($postId)));
    }

}
