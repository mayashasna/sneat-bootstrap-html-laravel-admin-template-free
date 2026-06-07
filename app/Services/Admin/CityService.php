<?php

namespace App\Services\Admin;

use App\Models\City;

class CityService
{
    // Store new city
    public function store(array $data): City
    {
        return City::create($data);
    }

    // Update existing city
    public function update(City $city, array $data): City
    {
        $city->update($data);
        return $city;
    }

    // Delete city
    public function delete(City $city): void
    {
        $city->delete();
    }

    // Enable city
    public function enable(City $city): void
    {
        $city->update(['is_active' => true]);
    }

    // Disable city
    public function disable(City $city): void
    {
        $city->update(['is_active' => false]);
    }
}
