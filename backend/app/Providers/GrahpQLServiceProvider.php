<?php

namespace App\Providers;

use GraphQL\Type\Definition\EnumType;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Nuwave\Lighthouse\Schema\TypeRegistry;
use Nuwave\Lighthouse\Schema\Types\LaravelEnumType;

class GrahpQLServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // 
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(TypeRegistry $typeRegistry)
    {   
        foreach ($this->getEnumClasses() as $enumClass) {
            $typeRegistry->register(new LaravelEnumType($enumClass));
        }
    }

    protected function getEnumClasses()
    {
        $classes = [];

        foreach (File::files(app_path('Enums')) as $file) {
            if ($file->getExtension() === 'php') {
                $classes[] = 'App\\Enums\\' . $file->getBasename('.php');
            }
        }

        return $classes;
    }
}
