<?php

namespace App\Models;

use App\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class Vehicule extends Model implements RepositoryInterface
{

    public function __construct(){

    }

    protected $table = 'vehicules';
    protected $primaryKey = 'id';
    protected $guarded = 'id';
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




    public static function find_by_id($id){
        return self::findOrFail($id);
    }


    public static function get($filters= [] , $page=1, $perPage= null){
        $query = self::query();
        if (isset($filters['category_id'])) $query->where('category_id', $filters['category_id']);
        
        if ($perPage) return $query->paginate($perPage, ['*'], 'page', $page);
        return $query->get();
    }


    public static function delete_by_id($id){

        $deletedRecords= self::destroy($id);
        if(!$deletedRecords) throw new \Exception("Failed to delete");
        return true;
    }
}
