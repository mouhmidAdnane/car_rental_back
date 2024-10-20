<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    protected $table = 'agencies';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    public $timestamps = false;

    protected $fillable = [
        'name',
        'url',
        'email',
        'phone',
        'image',
        'city'
    ];


    public function carPerAgency(){
        return $this->hasMany(CarPerAgency::class, 'agency_id');
    }

    public static function findById($id){
        return self::findOrFail($id);
    }

    private static function queryBuilder($filters){
        $query = self::query();
        if (isset($filters['city'])) $query->where('city', $filters['city']);
        if (isset($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

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

    public static function updateById($agency, $data){
        if($agency->update($data)) return true;
        throw new \Exception("Failed to update");
    }

}
