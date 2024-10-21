<?php

namespace App\Interfaces;

Interface RepositoryInterface{
    public static function get($filters= [] , $page=1, $perPage= null);
    public static function findById($id);
    public static function deleteById($id);
}