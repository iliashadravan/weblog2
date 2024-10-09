<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'title' => $this->title,
            'body' => $this->body,
            'likes_count' => $this->likes->count(), // تعداد لایک‌ها
            'average_rate' => $this->averageRating() ?? 'No rating', // میانگین امتیاز
        ];
    }
}
