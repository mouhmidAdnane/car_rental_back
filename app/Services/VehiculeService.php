<?php 

namespace App\Services;

use App\Models\Vehicule;
use App\Helper\CarBrands;
use App\Services\Service;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class VehiculeService extends Service{

    private function createValidationRules(){
        return [
            'category_id' => 'required|exists:categories,id',
            'a/c' => 'required|boolean',
            'suitcases' => 'required|integer|min:0',
            'doors' => 'required|integer|min:2|max:6', 
            'passengers' => 'required|integer|min:1',
            'automatic' => 'required|boolean',
            'brand' => 'required|in:' . CarBrands::$brands,
            'model' => 'required|string|max:255',
            'fuel_type' => 'required|in:petrol,diesel,electric,hybrid,gasoline',
        ];
    } 

    private function updateValidationRules($id){
        return [
            'category_id' => 'sometimes|required|exists:categories,id',
            'a/c' => 'sometimes|required|boolean',
            'suitcases' => 'sometimes|required|integer|min:0',
            'doors' => 'sometimes|required|integer|min:2|max:5', 
            'passengers' => 'sometimes|required|integer|min:1',
            'automatic' => 'sometimes|required|boolean',
            'brand' => 'sometimes|required|in:' . CarBrands::$brands,
            'model' => 'sometimes|required|string|max:255',
            'fuel_type' => 'sometimes|required|in:petrol,diesel,electric,hybrid,gasoline',
        ];
    }

    private function filterValidationRules(){
        return [
            'category_id' => 'nullable|integer|exists:categories,id', 
            'brand' => 'nullable|string|in:' . implode(',', CarBrands::$brands) 
        ];
    }

    

    public function __construct(ValidationService $validationService){
        parent::__construct($validationService);
    }


    public function create(array $data): Vehicule
    {
        $this->validationService->validate($data, $this->createValidationRules());
        return Vehicule::create($data);
    }
    
    
    public function update(int $id, array $data)
    {
        $vehicule = Vehicule::findById($id); 
        $this->validationService->validate($data, $this->updateValidationRules($id));
        if(Vehicule::updateVehicule($vehicule, $data)) 
            return [
                'status' => 'success',       
                'message' => 'Vehicule updated successfully',     
            ];
    }
    
    
    public function delete(int $id): bool
    {
        return Vehicule::deleteById($id);
    }

    
    public function getAll(array $filters = [], int $page = 1, ?int $perPage = null)
    {
        if(!empty($filters))
            $this->validationService->validate($filters, $this->filterValidationRules());

        $pagination = ['page' => $page];
        if ($perPage) $pagination['per_page'] = $perPage;
        $this->validationService->validate($pagination, $this->paginationRules);
    
        $vehicules= Vehicule::get($filters, $page, $perPage);

        if($vehicules->isEmpty()) throw new ModelNotFoundException("No agency found");
    
        if($perPage){
            $vehicules = $vehicules->toArray();
            unset($vehicules['links'], $vehicules['first_page_url'], $vehicules['last_page_url'], $vehicules['next_page_url'], $vehicules['prev_page_url'], $vehicules['path']);
        }
        
        return $vehicules;
    }

    
    public function findById(int $id): Vehicule
    {
        return Vehicule::findById($id); 
    }


    
}

