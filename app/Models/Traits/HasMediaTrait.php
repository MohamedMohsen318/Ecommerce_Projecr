<?php

namespace App\Models\Traits;

use App\Enums\MediaType;
use App\Models\Media;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasMediaTrait
{
    public function media(): MorphMany{
        return $this->morphMany(
            related: Media::class,
            name: 'model'
        );
    }
    public function getMedia(): Collection{
        if ($this->relationLoaded(key: 'media')) {
            return $this->media;
        }
        return $this->media()->get();
    }
    public function getFirstImage(): ?string{
        if ($this->relationLoaded(key: 'media')) {
            return $this->media->firstWhere(
                key: 'type',
                operator: MediaType::Image
            )?->file;
        }
        return $this->media()
            ->where('type', MediaType::Image->value)
            ->first()?->file;
    }
    public function getFirstImageUrl(): ?string{
        $image = $this->getFirstImage();

        return $image ? url('storage/' . ltrim($image, '/')) : null;
    }
    public function setMedia($image, MediaType|string $type, $path): void{
        $this->media()->updateOrCreate([
            'type' => $type instanceof MediaType ? $type->value : $type,
        ], [
            'file' => $image->store($path, 'public'),
        ]);
    }
}
