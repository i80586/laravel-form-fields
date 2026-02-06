<?php

declare(strict_types=1);

namespace i80586\Form;

use Illuminate\Support\ServiceProvider;

class FormFieldsServiceProvider extends ServicePro
{

    public function register(): void
    {
        // Мержим конфиг с дефолтным
        $this->mergeConfigFrom(
            __DIR__ . '/../config/form-fields.php',
            'form-fields'
        );
    }


}