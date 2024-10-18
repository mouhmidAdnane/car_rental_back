<?php

namespace App\Interfaces;

Interface RepositoryInterface{
    public static function get($filters= [] , $page=1, $perPage= null);
    public static function find_by_id($id);
    public static function delete_by_id($id);
}