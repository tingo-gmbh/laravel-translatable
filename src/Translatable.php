<?php

namespace Tingo\Translatable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\App;
use Tingo\Translatable\Exceptions\AttributeNotFoundException;
use Tingo\Translatable\Exceptions\AttributeNotTranslatableException;
use Tingo\Translatable\Models\Translation;

trait Translatable
{
    /**
     * Get all translations.
     *
     * @return MorphMany
     */
    public function translations(): MorphMany
    {
        return $this->morphMany(Translation::class, 'translatable');
    }

    /**
     * @param  string  $attribute
     * @param  string  $value
     * @param  string  $locale
     * @return Model
     * @throws AttributeNotFoundException
     * @throws AttributeNotTranslatableException
     */
    public function createTranslation(string $attribute, string $value, string $locale): Model
    {
        if (!$this->{$attribute}) {
            throw new AttributeNotFoundException("Attribute $attribute was not found on model ".get_class($this));
        }

        if (!$this->translatable) {
            throw new AttributeNotFoundException("Array translatable must be defined in ".get_class($this));
        }

        if (!in_array($attribute, $this->translatable)) {
            throw new AttributeNotTranslatableException("Attribute $attribute is not translatable");
        }

        return $this->translations()->create([
            'locale' => $locale,
            'attribute' => $attribute,
            'value' => $value,
        ]);
    }

    /**
     * Get translation of a specific attribute.
     *
     * @param  string  $attribute
     * @param  string|null  $locale
     * @param  bool  $refetch
     * @return string|null
     */
    public function getTranslation(string $attribute, string $locale = null, bool $refetch = true): ?string
    {
        if (!$this->{$attribute}) {
            return null;
        }

        if (!$this->translatable) {
            return null;
        }

        $locale = $locale ?: App::currentLocale();
        $translation = $refetch
            ? $this->fresh()
                ->translations()
                ->where('attribute', $attribute)
                ->where('locale', $locale)
                ->orderBy(
                    'created_at',
                    'desc'
                )->first()
            : $this->translations->first(fn($t) => $t->attribute === $attribute && $t->locale === $locale);

        if (!$translation) {
            return $this->{$attribute};
        }

        return $translation->value;
    }

    /**
     * Get all translations.
     *
     * @return array
     */
    public function getTranslations(): array
    {
        $translations = [];
        foreach ($this->translatable as $attribute) {
            $translations[$attribute] = ['default' => $this->{$attribute}];
            foreach (
                $this->fresh()->translations()->where('attribute', $attribute)->orderBy('created_at')->get(
                ) as $translation
            ) {
                $translations[$attribute][$translation->locale] = $translation->value;
            }
        }
        return $translations;
    }

    /**
     * Update an existing translation.
     *
     * @param  string  $attribute
     * @param  string  $value
     * @param  string  $locale
     * @return bool
     */
    public function updateTranslation(string $attribute, string $value, string $locale): bool
    {
        $translation = $this->translations()->where('attribute', $attribute)->where('locale', $locale)->orderBy(
            'created_at',
            'desc'
        )->first();
        if (!$translation) {
            return false;
        }

        $translation->update(['value' => $value]);

        return true;
    }

    /**
     * Delete translation.
     *
     * @param  string  $attribute
     * @param  string  $locale
     * @return bool
     */
    public function deleteTranslation(string $attribute, string $locale): bool
    {
        $translations = $this->translations()->where('attribute', $attribute)->where('locale', $locale)->get();
        if ($translations->count() === 0) {
            return false;
        }

        $translations->each(fn($t) => $t->delete());

        return true;
    }
}