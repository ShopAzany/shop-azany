<?php

ob_start();
class app
{
    
    protected $controller = 'home';
    protected $method = 'index';
    protected $params = [] ;
    protected $user;
    
    public function __construct() {
        
  
        //get url and check if the controller exists.........yes(initialise controller object) NO(controller remains home)
        $url = ($this->parse_url());
        
        // if(array_key_exists($url[0], $router)){
        
        
        $directory = @$url[0];
        $file_name = @$url[1];
        $function  = @$url[2];
        
        //checks if the directory (as specified in the url path) exists
        if (file_exists("app/controllers/$directory/" . $file_name . '.php')) {
            $this->controller = $file_name;
            //we unset the placeholders for the directory and file so the rest can be 
            //parameters. in the "call_user_func_array" at the bottom
            unset($url[0]); //for directory
            unset($url[1]); //for the controller file 
            
        } 
        elseif (file_exists("app/controllers/$directory")) {
            if ($directory == '') {
                $directory = Config::guest();
            } 
            else {
                Redirect::to("$directory/dashboard");
                
            }
            
        } 
        else {
            
            //this section defaults to using the router to match the 
            //appropriate controller 
            require_once 'router.php';
            if (array_key_exists($url[0], $router)) {
                
                $this->controller = $router[$url[0]];
                $directory        = Config::guest();
                $function         = @$url[1];
                
                
            }
            // echo "you need to create contoller file with name: $controller_filename.php";
            
            
            
        }
        
        // }
        /*
        print_r($url);
        echo $this->controller;
        echo $directory;
        echo $function;
        exit();*/


        if (! file_exists("app/controllers/$directory/" . $this->controller . '.php')) {

            $directory = Config::guest();
            $this->controller = 'error404';
            /*$user = User::where('username', $url[0])->first();
            if($user) {
                $this->controller = 'freelancer';
            }else{
                $this->controller = 'error404';
            }*/
        }


        require_once "app/controllers/$directory/" . $this->controller . '.php';
        
        
        $this->controller = new $this->controller($this->user);
        
        
        
        //check the controller method and call it
        
        $function = str_replace("-", "_", $function);
        
        
        if (method_exists($this->controller, $function)) {
            
            
            $this->method = $function;
            if ($directory != Config::guest()) {
                unset($url[2]); //unset the function if specified from url path
            }
            
        }
        
        
        /**
         * automatically store any form input by the user 
         */
        if (Input::exists()) {
            Input::store(Input::all());
        }
        
        
        
        
        
        $this->params = $url ? array_values($url): [];
        @call_user_func_array([$this->controller , $this->method] , $this->params);
        
    }
    
    public function parse_url()
    {
        
        if (isset($_GET['url'])) {
            
            return $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
    }
}


?> 