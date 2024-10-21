<?php

namespace App\Services;

use App\Services\ValidationService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class Service{

    protected $validationService;
    protected $paginationRules= [
            'page' => 'nullable|integer|min:1',
            'per_page' => 'nullable|integer|min:1',
        ];

    public function __construct(ValidationService $validationService){
        $this->validationService = $validationService;
    }

}