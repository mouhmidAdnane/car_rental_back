<?php

namespace App\Models;

use App\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class Category extends Model implements RepositoryInterface
{

    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $fillable = ['name', 'image'];


    public static $rules = [
        'name' => 'required|string|max:255',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ];

    public function vehicules()
    {
        return $this->hasMany(Vehicule::class);
    }

    public static function findById($id){
        return self::findOrFail($id);
    }


    public static function get($filters= [] , $page=1, $perPage= null){
        $query = self::query();
        if ($perPage) return $query->paginate($perPage, ['*'], 'page', $page);
        return $query->get();
    }


    public static function deleteById($id){

        $deletedRecords= self::destroy($id);
        if(!$deletedRecords) throw new \Exception("Failed to delete");
        return true;
    }
}
