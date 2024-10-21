<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgencyController;
use App\Http\Controllers\VehiculeController;
use App\Http\Controllers\VehiculePerAgencyController;


// Agency routes
Route::prefix('agencies')->group(function () {
    Route::post('/', [AgencyController::class, 'create']); // Create an agency
    Route::put('/{id}', [AgencyController::class, 'update'])->where('id', '[0-9]+');; // Update an agency
    Route::delete('/{id}', [AgencyController::class, 'delete'])->where('id', '[0-9]+');; // Delete an agency
    Route::get('/', [AgencyController::class, 'getAll']); // Get all agencies
    Route::get('/{id}', [AgencyController::class, 'findById'])->where('id', '[0-9]+');; // Get an agency by ID
});

// Vehicule routes
Route::prefix('vehicules')->group(function () {
    Route::post('/', [VehiculeController::class, 'create']); // Create a vehicle
    Route::put('/{id}', [VehiculeController::class, 'update'])->where('id', '[0-9]+');; // Update a vehicle
    Route::delete('/{id}', [VehiculeController::class, 'delete'])->where('id', '[0-9]+');; // Delete a vehicle
    Route::get('/', [VehiculeController::class, 'getAll']); // Get all vehicles
    Route::get('/{id}', [VehiculeController::class, 'findById'])->where('id', '[0-9]+');; // Get a vehicle by ID
});

// VehiculePerAgency routes
Route::prefix('vehicules-per-agency')->group(function () {
    Route::post('/', [VehiculePerAgencyController::class, 'store']); // Create vehicle for agency
    Route::put('/{id}', [VehiculePerAgencyController::class, 'update'])->where('id', '[0-9]+');; // Update vehicle for agency
    Route::delete('/{id}', [VehiculePerAgencyController::class, 'destroy'])->where('id', '[0-9]+');; // Delete vehicle for agency
    Route::get('/agency/{agencyId}', [VehiculePerAgencyController::class, 'getCarsByAgency'])->where('agency_id', '[0-9]+');; // Get cars by agency ID
    Route::get('/', [VehiculePerAgencyController::class, 'get']); // Get all vehicles for agencies
});
