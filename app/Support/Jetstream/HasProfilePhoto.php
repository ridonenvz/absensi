<?php

namespace Laravel\Jetstream;

trait HasProfilePhoto
{
    public function getProfilePhotoUrlAttribute(): string
    {
        if (! empty($this->profile_photo_path)) {
            return asset('storage/'.$this->profile_photo_path);
        }

        $name = urlencode($this->name ?? 'User');
        return "https://ui-avatars.com/api/?name={$name}&color=7F1D1D&background=FEE2E2";
    }
}
