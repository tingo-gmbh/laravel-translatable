# Laravel Translatable

Store translations items in your local database using Eloquent.

## Install

First install the latest version of our package.
```shell
composer require tingo-gmbh/laravel-translatable
```

Next we publish the migration and config files.
```shell
php artisan vendor:publish --provider="Tingo\LaravelTranslatable\LaravelTranslatableServiceProvider" --tag="config"
php artisan vendor:publish --provider="Tingo\LaravelTranslatable\LaravelTranslatableServiceProvider" --tag="migrations"
```

## Usage

### Model
Add the Translatable trait in your Eloquent model and specify the translatable attributes.

```injectablephp
<?php

namespace Tingo\LaravelTranslatable\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Tingo\LaravelTranslatable\Translatable;

class Entity extends Model
{
    use Translatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'category',
        'description',
        'unit',
        'price',
    ];

    /**
     * The attributes that are translatable.
     *
     * @var array<string>
     */
    protected array $translatable = [
        'name',
        'category',
        'description',
    ];
}
```

### Create
Create a new translation:
```injectablephp
$entity = Entity::create([
    'name' => 'Foo Entity',
    'category' => 'foo',
    'description' => 'This is my awesome entity!',
]);
$entity->createTranslation('name', 'Foo Entität', 'de');
$entity->createTranslation('name', 'L\'entité foo', 'fr');
```

### Update
A locale must always be passed as an argument, otherwise nothing will be updated.
```injectablephp
$entity->updateTranslation('name', 'Aktualisierte Foo Entität', 'de');
```

### Get
Finally, can return your translations in your Resources or anywhere else in your code.
```injectablephp
echo $entity->getTranslation('name', 'de');
// Foo Entität
echo $entity->getTranslation('name', 'fr');
// L\'entité foo
```

### Get all
If you do not provide a language, the package will use the default locale of your Laravel app. This is especially useful when passing locales as a request header to your API end points.
```injectablephp
App::setLocale('it');
$entity->createTranslation('name', 'Entità di Foo');
echo $entity->getTranslation('name');
// Entità di Foo
```
If you want to get all translations for a specific model, use the `getTranslations()` method. This will return translations of all attributes defined in the `$translatable` array.
```injectablephp
var_dump($entity->gatTranslations())
//  [
//      'name' =>  [
//          'default' => 'Foo Entity',
//          'de' => 'Foo Entität',
//          'fr' => 'L\'entité foo',
//      ], 
//      ...
//  ]
```

### Delete
A locale must always be passed as an argument, otherwise nothing will be deleted.
```injectablephp
$entity->deleteTranslation('name', 'de');
```