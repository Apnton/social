<?php

namespace App\Actions\Post;

use App\Models\Post\Post;
use App\Services\ImageServices;

class StoreAction
{
    public function __construct(
        private readonly ImageServices $imageServices,
        private readonly Post          $model
    )
    {
    }

    public function execute(array $data): Post
    {
        $imageName = $this->imageServices->storeWithResizeImage($data['image'], Post::IMAGE_FOLDER);
        $data['image'] = $imageName;
        $data['user_id'] = auth()->id();

        return $this->model->create($data);

    }
}
