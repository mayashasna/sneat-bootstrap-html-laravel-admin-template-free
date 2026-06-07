<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\City\StoreCityRequest;
use App\Http\Requests\Admin\City\UpdateCityRequest;
use App\Models\City;
use App\Services\Admin\CityService;

class CityController extends Controller
{
    protected CityService $service;

    public function __construct(CityService $service)
    {
        $this->service = $service;

        // Permissions
        $this->middleware('permission:view-city')->only('index');
        $this->middleware('permission:create-city')->only(['create', 'store']);
        $this->middleware('permission:edit-city')->only(['edit', 'update']);
        $this->middleware('permission:delete-city')->only('destroy');
        $this->middleware('permission:enable-city')->only('enable');
        $this->middleware('permission:disable-city')->only('disable');
    }

    // List all cities
    public function index()
    {
        $cities = City::latest()->get();
        return view('admin.cities.index', compact('cities'));
    }

    // Create page
    public function create()
    {
        return view('admin.cities.create');
    }

    // Store new city
    public function store(StoreCityRequest $request)
    {
        $this->service->store($request->validated());

        return redirect()
            ->route('admin.cities.index')
            ->with('success', __('admin.cities.created_success'));
    }

    // Edit page
    public function edit(City $city)
    {
        return view('admin.cities.edit', compact('city'));
    }

    // Update city
    public function update(UpdateCityRequest $request, City $city)
    {
        $this->service->update($city, $request->validated());

        return redirect()
            ->route('admin.cities.index')
            ->with('success', __('admin.cities.updated_success'));
    }

    // Delete city
    public function destroy(City $city)
    {
        $this->service->delete($city);

        return redirect()
            ->route('admin.cities.index')
            ->with('success', __('admin.cities.deleted_success'));
    }

    // Enable city
    public function enable(City $city)
    {
        $this->service->enable($city);

        return redirect()
            ->route('admin.cities.index')
            ->with('success', __('admin.cities.enabled_success'));
    }

    // Disable city
    public function disable(City $city)
    {
        $this->service->disable($city);

        return redirect()
            ->route('admin.cities.index')
            ->with('success', __('admin.cities.disabled_success'));
    }
    public function toggle(City $city)
{
    $city->is_active = !$city->is_active;
    $city->save();

    return back()->with('success', 'تم تغيير حالة المدينة');
}

}
