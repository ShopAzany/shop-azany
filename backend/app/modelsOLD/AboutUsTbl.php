<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class AboutUsTbl extends Eloquent 
{
    
    protected $fillable = [ 
        'id',   
        'title',
        'sub_title',
        'what_we_do',
        'vision',
        'mission',
        'who_we_serve',
        'title_image',
        'what_we_do_image',
        'vision_image',
        'created_at',
        'updated_at'
     ];
    
    protected $table = 'about_us';
    protected $primaryKey = 'id';
    protected $dates = [
        'created_at',
        'updated_at',

    ];

    

    


}
    
?>