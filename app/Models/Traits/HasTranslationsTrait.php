<?php

namespace App\Models\Traits;

use App\Models\ModelTranslation;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\App;

trait HasTranslationsTrait
{
    public function translations(): MorphMany
    {
        return $this->morphMany(
            related: ModelTranslation::class,
            name: 'model'
        );
    }

    public function translate($locale = null): ?ModelTranslation
    {
        $locale = $locale ?? App::getLocale();

        if ($this->relationLoaded(key: 'translations')) {
            return $this->translations->firstWhere(
                'locale',
                $locale
            );
        }

        return $this->translations()
            ->where('locale', $locale)
            ->first();
    }

    public function setTranslation($locale, $content): void
    {
        $data = [
            'name' => $content[$locale]['name'] ?? null,
            'description' => $content[$locale]['description'] ?? null,
        ];

        $this->translations()->updateOrCreate([
            'locale' => $locale
        ], $data);
    }
}
