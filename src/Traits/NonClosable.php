<?php

declare(strict_types=1);

namespace i80586\Form\Traits;

trait NonClosable
{

    protected function isClosable(): bool
    {
        return false;
    }

}