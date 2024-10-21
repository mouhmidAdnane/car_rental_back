<?php

namespace App\Http\Controllers;

use App\Services\AgencyService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class AgencyController extends Controller
{
    private $agencyService;

    public function __construct(AgencyService $agencyService)
    {
        $this->agencyService = $agencyService;
    }

    public function create(Request $request): JsonResponse
    {
        $data= $request->only(['name', 'city', 'url', 'email', 'phone', 'image']);
        try {

            $agency = $this->agencyService->create($data);
            return response()->json([
                'status' => 'success',
                'data' => $agency,
                'message' => 'Agency created successfully.'
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
                'message' => 'Failed to create agency.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $result = $this->agencyService->update($id, $request->all());
            return response()->json($result, 200);
        } 
        catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'agency not found.',
            ], 404);
        }
        catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error.',
                'errors' => $e->errors(),
            ], 422);
        }
        catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function delete(int $id): JsonResponse
    {
        try {
            $this->agencyService->delete($id);
            return response()->json([
                'status' => 'success',
                'message' => 'Agency deleted successfully.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete agency.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getAll(Request $request): JsonResponse
    {
        $filters = [
            'city' => $request->query('city', null),
            'name' => $request->query('name', null)
        ];
        $page = $request->query('page', 1); 
        $perPage = $request->query('per_page', null);
        
        try {
            $agencies = $this->agencyService->getAll($filters, $page, $perPage);
            $data = $perPage ? $agencies['data'] : $agencies;
            $response= response()->json($data, 200);
            if ($perPage) {
                unset($agencies['data']);
                $response= $response->withHeaders($agencies);
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
                'message' => 'Failed to retrieve agencies.',
            ], 500);
        }
    }

    public function findById(int $id): JsonResponse
    {
        try {
            $agency = $this->agencyService->findById($id);
            return response()->json($agency);
        }catch(ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Agency not found.',                
            ], 404);
        }
        catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to find agency.',
                'error' => $e->getMessage(),
            ], 404);
        }
    }
}
