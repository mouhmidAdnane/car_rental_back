<?php

namespace App\Models;

use App\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class Vehicule extends Model implements RepositoryInterface
{

    protected $table = 'vehicules';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    public $timestamps = false;

    protected $fillable = [
        "category_id",
        "a/c",
        "suitcases",
        "doors",
        "passengers",
        "automatic",
        "brand",
        "model",
        "fuel_type",
    ];
    



    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function carPerAgency(){
        return $this->hasMany(CarPerAgency::class, 'vehicule_id');
    }

    public static function findById($id){
        return self::findOrFail($id);
    }
    
    private static function queryBuilder($filters){
        $query = self::query();
        if (isset($filters['category_id'])) $query->where('category_id', $filters['category_id']);
        if (isset($filters['brand'])) $query->where('brand', $filters['brand']);
       
        return $query;
    }


    public static function get($filters= [] , $page=1, $perPage= null){
        
        $query = self::queryBuilder($filters); 
        if ($perPage) return $query->paginate($perPage, ['*'], 'page', $page);
        return $query->get();
    }

    public static function deleteById($id){
        $deletedRecords= self::destroy($id);
        if($deletedRecords === 0) throw new \Exception("Failed to delete");
        return true;
    }

    public static function updateVehicule(Vehicule $vehicule, array $data){
        if($vehicule->update($data)) return true;
        throw new \Exception("Failed to update");
    }
}
