<?php

namespace App\Http\Controllers;

use App\Services\VehiculeService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class VehiculeController extends Controller
{
    private $vehiculeService;

    public function __construct(VehiculeService $vehiculeService)
    {
        $this->vehiculeService = $vehiculeService;
    }

    public function create(Request $request): JsonResponse
    {
        $data = $request->only([
            'category_id', 'a/c', 'suitcases', 'doors', 'passengers', 
            'automatic', 'brand', 'model', 'fuel_type'
        ]);

        try {
            $vehicule = $this->vehiculeService->create($data);
            return response()->json([
                'status' => 'success',
                'data' => $vehicule,
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
                'message' => 'Failed to create vehicule.',
            ], 500);
        }
    }

    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $data = $request->only([
                'category_id', 'a/c', 'suitcases', 'doors', 'passengers', 
                'automatic', 'brand', 'model', 'fuel_type'
            ]);
            $result = $this->vehiculeService->update($id, $data);
            return response()->json($result, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Vehicule not found.',
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
                'message' => 'Failed to update vehicule.',
            ], 500);
        }
    }

    public function delete(int $id): JsonResponse
    {
        try {
            $this->vehiculeService->delete($id);
            return response()->json([
                'status' => 'success',
                'message' => 'Vehicule deleted successfully.'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Vehicule not found.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete vehicule.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getAll(Request $request): JsonResponse
    {
        $filters = [
            'brand' => $request->query('brand', null),
            'category_id' => $request->query('category_id', null)
        ];
        
        $page = $request->query('page', 1);
        $perPage = $request->query('per_page', null);
        
        try {
            $vehicules = $this->vehiculeService->getAll($filters, $page, $perPage);
            $data = $perPage ? $vehicules['data'] : $vehicules;
            $response = response()->json($data, 200);
            if ($perPage) {
                unset($vehicules['data']);
                $response = $response->withHeaders($vehicules);
            }
            return $response;

        } catch(ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 404);
        } catch(ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve vehicules.',
            ], 500);
        }
    }

    public function findById(int $id): JsonResponse
    {
        try {
            $vehicule = $this->vehiculeService->findById($id);
            return response()->json($vehicule, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Vehicule not found.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to find vehicule.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
