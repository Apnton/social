<?php

namespace App\Http\Controllers\Api\Chat;

use App\Actions\Chat\GetMessagesByChatIdAction;
use App\Actions\Chat\StoreChatAction;
use App\Actions\Chat\StoreChatMessageAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Chat\StoreChatMessageRequest;
use App\Http\Requests\Chat\StoreChatRequest;
use App\Http\Resources\Chat\ChatMessageResource;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    use ApiResponser;

    public function storeChat(StoreChatRequest $request, StoreChatAction $action): JsonResponse
    {
        return $this->successResponse(['chat_id' => $action->execute($request->validated())]);
    }

    public function storeMessage(StoreChatMessageRequest $request, StoreChatMessageAction $action): JsonResponse
    {
        return $this->successResponse(ChatMessageResource::make($action->execute($request->validated())));
    }
    public function getMessagesByChatId(int $chatId, Request $request, GetMessagesByChatIdAction $action): array
    {
        return $this->paginate(ChatMessageResource::class, $action->execute($chatId, $request->get('limit')));
    }
}
