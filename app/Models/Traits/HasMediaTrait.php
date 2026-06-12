<?php

namespace App\Models\Traits;

use App\Models\Media;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasMediaTrait
{
    public function media(): MorphMany
    {
        return $this->morphMany(
            related: Media::class,
            name: 'model'
        );
    }

    public function getMedia(): Collection
    {
        if ($this->relationLoaded(key: 'media')) {
            return $this->media;
        }
        return $this->media()->get();
    }

    public function getFirstImage(): string
    {
        if ($this->relationLoaded(key: 'media')) {
            return $this->media->firstWhere(
                key: 'type',
                operator: 'image'
            )?->file;
        }
        return $this->media()
            ->where('type', 'image')
            ->first()?->file;
    }

    public function setMedia($image, $type, $path): void
    {
        $this->media()->updateOrCreate([
            'type' => $type,
        ], [
            'file' => $image->store($path, 'public'),
        ]);
    }


}
