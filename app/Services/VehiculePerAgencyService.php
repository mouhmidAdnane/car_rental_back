<?php 

namespace  App\Services;

use App\Services\Service;
use App\Models\CarPerAgency;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class VehiculePerAgencyService extends Service{
    

    private  $filterValidationRules = [
        'available' => 'nullable|boolean', 
        'reserved' => 'nullable|boolean', 
        'picked_up' => 'nullable|boolean', 
        'agency_id' => 'nullable|integer|exists:agencies,id', 
    ];
    

    private function baseValidationRules($data = [], int $stock = 0, $required = true)
    {
        return [
            'agency_id' => ($required ? 'required' : 'sometimes') . '|exists:agencies,id',
            'vehicule_id' => ($required ? 'required' : 'sometimes') . '|exists:vehicules,id',
            'stock' => ($required ? 'required' : 'sometimes') . '|integer|min:0',
            'available' => ($required ? 'required' : 'sometimes') . '|integer|min:0|max:' . ($data['stock'] ?? $stock),
            'reserved' => ($required ? 'required' : 'sometimes') . '|integer|min:0|max:' . ($data['stock'] ?? $stock),
            'picked_up' => ($required ? 'required' : 'sometimes') . '|integer|min:0|max:' . ($data['stock'] ?? $stock),
            'price_per_day' => ($required ? 'required' : 'sometimes') . '|numeric|min:0',
            'total' => [
                $required ? 'required' : 'sometimes',
                function ($attribute, $value, $fail) use ($data, $stock) {
                    $total = ($data['available'] ?? 0) + ($data['reserved'] ?? 0) + ($data['picked_up'] ?? 0);
                    $stockValue = $data['stock'] ?? $stock;

                    if ($total > $stockValue) {
                        $fail('The sum of available, reserved, and picked_up must not exceed stock.');
                    }
                },
            ],
        ];
    }


    private function createValidationRules($data = []){
        return self::baseValidationRules($data, 0, true);
    }

    private function updateValidationRules($data = [], int $currentStock){
        return self::baseValidationRules($data, $currentStock, false);
    }

    

    public function __construct(ValidationService $validationService){
        parent::__construct($validationService);
    }


    public function create(array $data)
    {
        $this->validationService->validate($data, $this->createValidationRules($data));
        return CarPerAgency::create($data);
    }

    public function update(int $id, array $data)
    {
        $carPerAgency = CarPerAgency::findById($id);
        $currentStock = $carPerAgency->stock;
        $this->validationService->validate($data, $this->updateValidationRules($data, $currentStock));
        $carPerAgency->update($data);
        return $carPerAgency;
    }

    public function delete(int $id)
    {
        return CarPerAgency::deleteById($id);
    }

    // public function getCarsByAgency(int $agencyId, array $filters = [], int $page = 1, int $perPage = null)
    // {
    //     $this->validationService->validate($filters, $this->filterValidationRules);
    //     return CarPerAgency::getCarsByAgency($agencyId, $filters, $page, $perPage);
    // }

    public function get(array $filters = [], int $page = 1, int $perPage = null)
    {
        if(!empty($filters))
            $this->validationService->validate($filters, $this->filterValidationRules);

        $pagination = ['page' => $page];
        if ($perPage) $pagination['per_page'] = $perPage;
        $this->validationService->validate($pagination, $this->paginationRules);

        $vehiculesPerAgency= CarPerAgency::get($filters, $page, $perPage);
        if($vehiculesPerAgency->isEmpty()) throw new ModelNotFoundException("Not found");
        
        if($perPage){
            $vehiculesPerAgency = $vehiculesPerAgency->toArray();
            unset($vehiculesPerAgency['links'], $vehiculesPerAgency['first_page_url'], $vehiculesPerAgency['last_page_url'], $vehiculesPerAgency['next_page_url'], $vehiculesPerAgency['prev_page_url'], $vehiculesPerAgency['path']);
        }

        return $vehiculesPerAgency;
    }


}