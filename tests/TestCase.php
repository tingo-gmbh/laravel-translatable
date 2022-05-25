<?php

namespace Tingo\Translatable\Tests;

use Exception;
use Tingo\Translatable\TranslatableServiceProvider;
use Tingo\Translatable\Tests\Models\Entity;

class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        // additional setup
    }

    /**
     * @param $app
     * @return string[]
     */
    protected function getPackageProviders($app): array
    {
        return [
            TranslatableServiceProvider::class,
        ];
    }

    /**
     * @param $app
     * @return void
     */
    protected function getEnvironmentSetUp($app): void
    {
        $translations = require __DIR__ . '/../database/migrations/2022_05_24_154339_create_translations_table.php';
        if (is_object($translations)) {
            $translations->up();
        }
        $entities = require __DIR__ . '/../database/migrations/2022_05_24_154340_create_entities_table.php';
        if (is_object($entities)) {
            $entities->up();
        }
    }

    /**
     * @return Entity
     */
    public function createTestEntity(): Entity
    {
        return Entity::create([
            'name' => 'Foo entity',
            'category' => 'foo',
            'description' => 'This is an awesome entity!',
            'unit' => 'pounds',
            'price' => 25.50
        ]);
    }
}