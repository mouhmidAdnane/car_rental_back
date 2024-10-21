<?php

namespace App\Http\Controllers;

use App\Services\VehiculePerAgencyService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class VehiculePerAgencyController extends Controller
{
    private $vehiculePerAgencyService;

    public function __construct(VehiculePerAgencyService $vehiculePerAgencyService)
    {
        $this->vehiculePerAgencyService = $vehiculePerAgencyService;
    }


    public function store(Request $request): JsonResponse
    {
        $data = $request->only(['agency_id', 'vehicule_id', 'stock', 'available', 'reserved', 'picked_up', 'price_per_day']);
        
        try {
            $car = $this->vehiculePerAgencyService->create($data);
            return response()->json([
                'status' => 'success',
                'data' => $car,
                'message' => 'Vehicle created successfully.'
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create vehicle.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $data= $request->all();
        try {
            $result = $this->vehiculePerAgencyService->update($id, $data);
            return response()->json([
                'status' => 'success',
                'data' => $result,
                'message' => 'Vehicle updated successfully.'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Vehicle not found.',
            ], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update vehicle.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $this->vehiculePerAgencyService->delete($id);
            return response()->json([
                'status' => 'success',
                'message' => 'Vehicle deleted successfully.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete vehicle.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function get(Request $request): JsonResponse
    {
        $filters = [
            'agency_id' => $request->query('agency_id', null),
            'available' => $request->query('available', null),
            'reserved' => $request->query('reserved', null),
            'picked_up' => $request->query('picked_up', null),
        ];
        $page = $request->query('page', 1); 
        $perPage = $request->query('per_page', null);
        try {

            $cars = $this->vehiculePerAgencyService->get($filters, $page, $perPage);
            $data = $perPage ? $cars['data'] : $cars;
            $response = response()->json($data, 200);
            if ($perPage) {
                unset($cars['data']);
                $response = $response->withHeaders($cars);
            }
            return $response;
          
        } 
        catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error.',
                'errors' => $e->errors(),
            ], 422);
        }
        catch(ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Vehicle not found.',      
            ], 404);
        }
        catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve vehicles.',  
                'error' => $e->getMessage(),  
            ], 500);
        }
    }
}
