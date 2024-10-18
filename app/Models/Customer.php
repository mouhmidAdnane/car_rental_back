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
