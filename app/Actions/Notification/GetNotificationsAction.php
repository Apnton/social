<?php

namespace App\Actions\Notification;

use Illuminate\Pagination\LengthAwarePaginator;

class GetNotificationsAction
{
    public function execute(?string $type, ?int $limit = 15): LengthAwarePaginator
    {
        $query = auth()->user()->notifications();

        $query
            ->when($type === 'unread', function ($when) {
                $when->whereNull('read_at');
            })
            ->when($type === 'read', function ($when) {
                $when->whereNotNull('read_at');
            });

        return $query->paginate($limit);
    }

}
