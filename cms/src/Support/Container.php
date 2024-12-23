<?php

namespace App\Support;
class Container
{
    private array $instances = [];
    private array $recipes = [];

    public function bind(string $what, \Closure $recipe): void
    {
        $this->recipes[$what] = $recipe;
    }

    public function get($what)
    {
        if (empty($this->instances[$what])) {
            if (empty($this->recipes[$what])) {
                echo 'Could not build: ' . $what;
                die();
            }
            $this->instances[$what] = $this->recipes[$what]();
        }
        return $this->instances[$what];

    }


}

