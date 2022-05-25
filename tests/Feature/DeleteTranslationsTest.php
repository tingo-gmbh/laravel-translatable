<?php

namespace Tingo\Translatable\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tingo\Translatable\Tests\TestCase;

class DeleteTranslationsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @group default
     */
    public function testDeleteSuccessful()
    {
        $entity = $this->createTestEntity();

        $entity->createTranslation('name', 'Meine Entität', 'de');

        $this->assertSame('Meine Entität', $entity->getTranslation('name', 'de'));

        $entity->deleteTranslation('name', 'de');

        $this->assertSame('Foo entity', $entity->getTranslation('name', 'de'));
    }
}