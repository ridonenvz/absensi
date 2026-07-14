<?php

namespace Laravel\Sanctum;

trait HasApiTokens
{
    public function tokens()
    {
        return collect();
    }
}
