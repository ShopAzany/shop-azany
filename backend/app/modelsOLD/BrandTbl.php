<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class BrandTbl extends Eloquent 
{
    
    protected $fillable = [ 
        'id',   
        'name',
        'image',
        'created_at',
        'updated_at'
     ];
    
    protected $table = 'brand';
    protected $primaryKey = 'id';
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    

}
    
?>