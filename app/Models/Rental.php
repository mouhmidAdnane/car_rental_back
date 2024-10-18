<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    protected $table = 'rentals';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $fillable = [
        'customer_id',
        'car_per_agency_id',
        'status',
        'start',
        'end',
        'price'
    ];

    public function carPerAgency()
    {
        return $this->belongsTo(CarPerAgency::class,'car_per_agency_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public static function find_by_id($id){
        return self::findOrFail($id);
    }


    public static function get($filters= [] , $page=1, $perPage= null){
        $query = self::query();
        if (isset($filters['status'])) $query->where('status', $filters['status']);
        if (isset($filters['start_today'])){
            $today= now()->format('Y-m-d');
            $query->where('start', $today);
        }
        if (isset($filters['end_today'])){
            $today= now()->format('Y-m-d');
            $query->where('end', $today);
        }
        
        if ($perPage) return $query->paginate($perPage, ['*'], 'page', $page);
        return $query->get();
    }


    public static function delete_by_id($id){

        $deletedRecords= self::destroy($id);
        if(!$deletedRecords) throw new \Exception("Failed to delete");
        return true;
    }
}
