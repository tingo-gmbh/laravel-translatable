<?php

namespace Tingo\LaravelTranslatable\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Tingo\LaravelTranslatable\Tests\TestCase;

class GetTranslationsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @group default
     */
    public function testAttributeNotTranslatable()
    {
        $entity = $this->createTestEntity();
        $entity->createTranslation('name', 'Meine Entität', 'de');

        $this->assertNull($entity->getTranslation('foo'));
    }

    /**
     * @group default
     */
    public function testDefaultValue()
    {
        $entity = $this->createTestEntity();
        $this->assertSame('Foo entity', $entity->getTranslation('name'));
        $this->assertSame('pounds', $entity->getTranslation('unit'));
    }

    /**
     * @group default
     */
    public function testSuccessfulWithLocale()
    {
        $entity = $this->createTestEntity();
        $entity->createTranslation('name', 'Meine Entität', 'de');

        $this->assertSame('Meine Entität', $entity->getTranslation('name', 'de'));
    }

    /**
     * @group default
     */
    public function testSuccessfulWithoutLocale()
    {
        $entity = $this->createTestEntity();
        $entity->createTranslation('name', 'Meine Entität', 'de');

        App::setLocale('de');
        $this->assertSame('Meine Entität', $entity->getTranslation('name'));
    }

    /**
     * @group default
     */
    public function testGetAllTranslations()
    {
        $entity = $this->createTestEntity();
        $entity->createTranslation('name', 'Meine Entität', 'de');
        $entity->createTranslation('name', 'Mon entité', 'fr');

        $translations = $entity->getTranslations();
        $this->assertSame('Foo entity', $translations['name']['default']);
        $this->assertSame('Meine Entität', $translations['name']['de']);
        $this->assertSame('Mon entité', $translations['name']['fr']);
    }
}