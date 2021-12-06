<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class FaqTbl extends Eloquent 
{
    
    protected $fillable = [ 
        'id',   
        'question',
        'answer',
        'status',
        'created_at',
        'updated_at'
    ];
    
    protected $table = 'faq';
    protected $casts = [ 
        'id' => 'integer', 
        'status' => 'integer', 
    ];
    protected $primaryKey = 'id';
    protected $dates = [
        'created_at',
        'updated_at',
    ];


    public static function createRow($question, $answer){
        return self::create([
            'question' => $question,
            'answer' => $answer,
        ]);
    }

    public static function updateRow($id, $question, $answer, $status){
        return self::where('id', $id)->update([
            'question' => $question,
            'answer' => $answer,
            'status' => $status,
        ]);
    }

    public static function deleteRow($id){
        return self::where('id', $id)->delete();
    }


    public static function single($id){
        return self::where('id', $id)->first();
    }

    public static function getForGuest(){
        return self::where('status', 1)->get();
    }

    

}
    
?>