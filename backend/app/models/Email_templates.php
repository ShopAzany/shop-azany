<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class Email_templates extends Eloquent 
{
    
    protected $fillable = [ 
        'id',   
        'title',
        'content',
        'footer',
        'created_at',
        'updated_at'
    ];
    
    protected $table = 'email_templates';
    protected $casts = [ 
        'id' => 'integer', 
    ];
    protected $primaryKey = 'id';
    protected $dates = [
        'last_updated',
        'created_at',
        'updated_at',
    ];

    public function getRecords() {
        return self::get();
    }

    public static function getById($id){
        return self::where('id', $id)->first();
    }


}
    
?>