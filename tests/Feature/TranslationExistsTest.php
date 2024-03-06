<?php

namespace Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tingo\Translatable\Tests\TestCase;

class TranslationExistsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @group default
     */
    public function testTranslationExists()
    {
        $entity = $this->createTestEntity();
        $this->assertFalse($entity->translationExists('foobar', 'de'));
        $this->assertFalse($entity->translationExists('name', 'de'));
        $entity->createTranslation('name', 'Meine Entität', 'de');
        $this->assertTrue($entity->translationExists('name', 'de'));
    }

}