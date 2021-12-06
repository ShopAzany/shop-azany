<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class WebsiteSettings extends Eloquent 
{
	
	protected $fillable = [ 
        'id',  
        'biz_name',
        'site_name',
        'site_title',
        'site_email',
        'site_description',
        'site_url',
        'favicon_url',
        'logo_url',
        'dsbd_logo_icon',
        'dsbd_logo_body',
        'biz_addr',
        'biz_city',
        'biz_state',
        'biz_country',
        'biz_phone',
        'chat_code',
        'last_modified',
        'created_at',
        'updated_at'
	 ];
     
	protected $primaryKey = 'id';
	protected $table = 'website_settings';
  	protected $dates = [
        'created_at',
        'updated_at'
    ];


    public static function insertTable($subData=array()){
        if($subData->id){
            $info = self::where('id', $subData->id)->update([
                'site_name'            => $subData->site_name,
                'site_title'           => $subData->site_title,
                'site_description'     => $subData->site_description,
                'site_url'             => $subData->site_url,
                'favicon_url'          => $subData->favicon_url,
                'logo_url'             => $subData->logo_url,
                'biz_addr'             => $subData->biz_addr,
                'biz_state'            => $subData->biz_state,
                'biz_country'          => $subData->biz_country,
                'biz_phone'            => $subData->biz_phone
            ]);
        }
        else {
            $info = self::create([
                'site_name'            => $subData->site_name,
                'site_title'           => $subData->site_title,
                'site_description'     => $subData->site_description,
                'site_url'             => $subData->site_url,
                'favicon_url'          => $subData->favicon_url,
                'logo_url'             => $subData->logo_url,
                'biz_addr'             => $subData->biz_addr,
                'biz_state'            => $subData->biz_state,
                'biz_country'          => $subData->biz_country,
                'biz_phone'            => $subData->biz_phone
            ]);

        }

        return $info;
    }


    public static function single(){
        return self::first();
    }


}

?>