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
