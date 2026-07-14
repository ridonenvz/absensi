<?php

namespace Laravel\Fortify;

trait TwoFactorAuthenticatable
{
    public function hasEnabledTwoFactorAuthentication(): bool
    {
        return ! empty($this->two_factor_secret);
    }
}
