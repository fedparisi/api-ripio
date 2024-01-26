<?php

namespace App\Service\Exchange\Ripio\Resource;

interface Resource
{
    public function getValue(self $enum, array $routeParams = []): string;
}
