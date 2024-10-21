<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'email',
        'phone',
        'adress',
        'city',
        'birth_date',
    ];

    public static $validationRules = [
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'gender' => 'required | in :0,1',
        'email' => 'required|email|max:255|unique:your_table_name,email',
        'phone' => 'nullable|string|max:20', 
        'adress' => 'nullable|string|max:255',
        'city' => 'required|string|max:100',
        'birth_date' => 'required|date|date_format:Y-m-d|before:today',
    ];

    public function rentals(){
        return $this->hasMany(Rental::class, 'customer_id');
    }

    public static function find_by_id($id){
        return self::findOrFail($id);
    }


    public static function get($filters= [] , $page=1, $perPage= null){
        $query = self::query();
        if (isset($filters['city'])) $query->where('city', $filters['city']);
        if ($perPage) return $query->paginate($perPage, ['*'], 'page', $page);
        return $query->get();
    }


    public static function delete_by_id($id){

        $deletedRecords= self::destroy($id);
        if(!$deletedRecords) throw new \Exception("Failed to delete");
        return true;
    }
}
