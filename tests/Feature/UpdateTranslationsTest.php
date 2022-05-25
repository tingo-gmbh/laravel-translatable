<?php

namespace Tingo\LaravelTranslatable\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tingo\LaravelTranslatable\Models\Translation;
use Tingo\LaravelTranslatable\Tests\TestCase;

class UpdateTranslationsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @group default
     */
    public function testUpdateTranslation()
    {
        $entity = $this->createTestEntity();
        $entity->createTranslation('name', 'Meine Entität', 'de');
        $this->assertSame('Meine Entität', $entity->getTranslation('name', 'de'));

        $this->assertTrue($entity->updateTranslation('name', 'Meine aktualisierte Entität', 'de'));
        $this->assertSame('Meine aktualisierte Entität', $entity->getTranslation('name', 'de'));

        $this->assertFalse($entity->updateTranslation('name', 'Mon entité nouveaux', 'fr'));
    }
}