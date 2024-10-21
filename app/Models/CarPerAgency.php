<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Interfaces\RepositoryInterface;

class CarPerAgency extends Model implements RepositoryInterface
{

    protected $table = 'agency_vehicule';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    public $timestamps = true;

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


    public static function findById($id){
        return self::findOrFail($id);
    }

    private static function queryBuilder($filters){
        $query = self::query()->with('vehicule.category:id,name');
       
        if (isset($filters['available'])){
            $operation= $filters['available'] ? '>' : '=';
            $filters['available'] ?? $query->where('available',  $operation , '0');
        }   
        if (isset($filters['reserved'])) {
            $operation = $filters['reserved'] ? '>' : '=';
            $query->where('reserved', $operation, '0');
        }
        
        if (isset($filters['picked_up'])) {
            $operation = $filters['picked_up'] ? '>' : '=';
            $query->where('picked_up', $operation, '0');
        }
        
        if (isset($filters['agency_id']))   $query->where('agency_id', $filters['agency_id']);

        return $query;
    }

    public static function get($filters= [] , $page=1, $perPage= null){
        $query = self::queryBuilder($filters)->orderBy('agency_id', 'asc');
        return $perPage ? $query->paginate($perPage, ['*'], 'page', $page) : $query->get();
    }


    public static function deleteById($id){
        $deletedRecords= self::destroy($id);
        if($deletedRecords === 0) throw new \Exception("Failed to delete");
        return true;
    }

    
}
