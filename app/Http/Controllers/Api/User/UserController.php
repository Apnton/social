<?php

namespace App\Http\Controllers\Api\User;

use App\Actions\Notification\CountUnreadNotificationAction;
use App\Actions\Notification\GetNotificationsAction;
use App\Actions\Post\GetPostsByUserAction;
use App\Actions\User\GetAllUsersAction;
use App\Actions\User\GetProfileAction;
use App\Actions\User\GetUserStatisticByIdAction;
use App\Actions\User\ToggleFollowingAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Notification\GetNotificationRequest;
use App\Http\Resources\Notification\NotificationResource;
use App\Http\Resources\Post\PostResource;
use App\Http\Resources\User\UserResource;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ApiResponser;

    public function getProfile(GetProfileAction $action): JsonResponse
    {
        return $this->successResponse(UserResource::make($action->execute()));
    }

    public function getAllUsers(Request $request, GetAllUsersAction $action): array
    {
        return $this->paginate(UserResource::class, $action->execute($request->get('limit')));
    }

    public function getUserPosts(int $userId, Request $request, GetPostsByUserAction $action): array
    {
        return $this->paginate(PostResource::class, $action->execute($userId, $request->get('limit')));
    }

    public function toggleFollowing(int $userId, ToggleFollowingAction $action): JsonResponse
    {
        try {
            return $this->successResponse(UserResource::make($action->execute($userId)));
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), $exception->getCode());
        }
    }

    public function getStatistic(int $id, GetUserStatisticByIdAction $action): JsonResponse
    {
        return $this->successResponse($action->execute($id));
    }

    public function getCountUnread(CountUnreadNotificationAction $action): JsonResponse
    {
        return $this->successResponse($action->execute());
    }

    public function getNotifications(GetNotificationRequest $request, GetNotificationsAction $action)
    {
        return $this->paginate(NotificationResource::class, $action->execute(
            $request->get('type'),
            $request->get('limit')
        ));
    }

}
