<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarPerAgency extends Model
{

    protected $table = 'agency_vehicule';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    protected $fillable = [
        'agency_id',
        'vehicule_id',
        'stock',
        'available',
        'reserved',
        'picked_up',
        'license_plate',
        'color',
        'price_per_day',
    ];

    public function rental(){
        return $this->hasMany(Rental::class, 'car_per_agency_id');
    }

    public function vehicule(){
        return $this->belongsTo(Vehicule::class, 'vehicule_id');
    }

    public function agency()
    {
        return $this->belongsTo(Agency::class,'car_per_agency_id');
    }

    public static function find_by_id($id){
        return self::findOrFail($id);
    }


    private static function queryBuilder($filters){
        $query = self::query()->with('vehicule');
        if (isset($filters['available'])) {
            $query->where('available', $filters['available'] > 0);
        }
        if (isset($filters['reserved'])) {
            $query->where('reserved', $filters['reserved'] > 0);
        }
        if (isset($filters['picked_up'])) {
            $query->where('picked_up', $filters['picked_up'] > 0);
        }

        return $query;
    }

    public static function getCarsByAgency($agencyId, $filters = [], $page = 1, $perPage = null){
        $query = self::queryBuilder($filters)->where('agency_id', $agencyId);
        return $perPage ? $query->paginate($perPage, ['*'], 'page', $page) : $query->get();
    }

    public static function get($filters= [] , $page=1, $perPage= null){
        $query = self::queryBuilder($filters);
        return $perPage ? $query->paginate($perPage, ['*'], 'page', $page) : $query->get();
    }


    public static function delete_by_id($id){

        $deletedRecords= self::destroy($id);
        if(!$deletedRecords) throw new \Exception("Failed to delete");
        return true;
    }

    
}
