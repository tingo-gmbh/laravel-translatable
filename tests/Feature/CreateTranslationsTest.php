<?php

namespace Tingo\LaravelTranslatable\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Tingo\LaravelTranslatable\Exceptions\AttributeNotFoundException;
use Tingo\LaravelTranslatable\Exceptions\AttributeNotTranslatableException;
use Tingo\LaravelTranslatable\Tests\TestCase;


class CreateTranslationsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @group default
     */
    public function testAttributeNotFound()
    {
        $this->expectException(AttributeNotFoundException::class);
        $this->createTestEntity()->createTranslation('unknown', 'Meine Entität', 'de');
    }

    /**
     * @group default
     */
    public function testAttributeNotTranslatable()
    {
        $this->expectException(AttributeNotTranslatableException::class);
        $this->createTestEntity()->createTranslation('unit', 'Pfund', 'de');
    }

    /**
     * @group default
     */
    public function testSuccessfulWithLocale()
    {
        $translation = $this->createTestEntity()->createTranslation('name', 'Meine Entität', 'de');
        $this->assertSame($translation->attribute, 'name');
        $this->assertSame($translation->value, 'Meine Entität');
        $this->assertSame($translation->locale, 'de');
    }
}