<?php

namespace App\Services;

use App\Models\Agency;
use App\Services\Service;
use App\Services\ValidationService;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AgencyService extends Service{

    private $createValidationRules= [
        'name' => 'required|string|max:255|unique:agencies,name',
        'url' => 'nullable|url|max:255',
        'email' => 'required|email|max:255|unique:agencies,email',
        'phone' => 'nullable|string|max:20|unique:agencies,phone',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'city' => 'required|string|max:100',
    ];

    private function updateValidationRules($id){
        return  [
            'name' => 'nullable|string|max:255|unique:agencies,name,' . $id,
            'url' => 'nullable|url|max:255',
            'email' => 'nullable|email|max:255|unique:agencies,email,' . $id,
            'phone' => 'nullable|string|max:20|unique:agencies,phone,' . $id,
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'city' => 'nullable|string|max:100',
        ];
    }

    private $filterValidationRules = [
        'name' => 'nullable|string|max:255',
        'city' => 'nullable|string|max:100',
    ];



    

    public function __construct(ValidationService $validationService){
        parent::__construct($validationService);
    }

    public function create(array $data): Agency
    {
        $this->validationService->validate($data, $this->createValidationRules);
        return Agency::create($data);
    }
    
    
    public function update(int $id, array $data)
    {
        $agency = Agency::find_by_id($id); 
        $this->validationService->validate($data, $this->updateValidationRules($id));
        if(Agency::update_by_id($agency, $data)) 
            return [
                'status' => 'success',       
                'message' => 'Agency updated successfully',     
            ];
    }
    
    
    public function delete(int $id): bool
    {
        return Agency::deleteById($id);
    }

    public function getAll(array $filters = [], int $page = 1, ?int $perPage = null)
    {
        if(!empty($filters))
            $this->validationService->validate($filters, $this->filterValidationRules);

        $pagination = ['page' => $page];
        if ($perPage) $pagination['per_page'] = $perPage;
        $this->validationService->validate($pagination, $this->paginationRules);

        $agencies= Agency::get($filters, $page, $perPage);

        if($agencies->isEmpty()) throw new ModelNotFoundException("No agency found");
        
        if($perPage){
            $agencies = $agencies->toArray();
            unset($agencies['links'], $agencies['first_page_url'], $agencies['last_page_url'], $agencies['next_page_url'], $agencies['prev_page_url'], $agencies['path']);
        }

        return $agencies;
    }
  

    
    public function findById(int $id): Agency
    {
        return Agency::findById($id); 
    }
}