<?php

namespace HelloExample\People;

class Sergiy implements PeopleInterface
{
    protected string $name = 'Sergiy';

    public function getName(): string
    {
        return $this->name;
    }
}