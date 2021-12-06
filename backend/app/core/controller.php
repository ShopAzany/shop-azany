<?php
@session_start();


/**
 * this is the base controller which other conrtollers extends
 */
require_once 'operations.php';

class controller extends operations
{
    
    
    public function inputErrors()
    {
        if (Input::errors()) {
            
            
            $output = ' <div class="list-group" style="text-align:center;">';
            
            
            foreach (Input::errors() as $field => $errors) {
                
                
                $field = ucfirst(str_replace('_', ' ', $field));
                
                $output .= ' <a class="list-group-item list-group-item-danger">
                 <strong class="list-group-item-heading">' . $field . '</strong>';
                
                foreach ($errors as $error) {
                    
                    $error = ucfirst(str_replace('_', ' ', $error));
                    
                    $output .= '<p class="list-group-item-text">' . $error . '</p>';
                    
                    
                    
                }
                
                $output .= '</a>';
                
                
                
            }
            
            $output .= '</div>';
            
            
        }
        
        
        return $output;
        
        
    }
    
    
    
    
    public function inputError($field)
    {
        
        $output = '  <span role="alert">';
        
        if (Input::errors($field)) {
            foreach (Input::errors($field) as $error) {
                $error = ucfirst(str_replace('_', ' ', $error));
                $output .= $error . ' ';
            }
            
            $output .= '</span>';
            return $output;
            
        }
        
    }
    
    public function validator()
    {
        
        if (isset($this->validator)) {
            return $this->validator;
        }
        return $this->validator = new Validator;
    }
    
    
    
    
    public function csrf_field($csrf_field = "")
    {
        echo '<input type="hidden" name="' . $csrf_field . '" value="' . Token::csrf($csrf_field) . '">';
    }
    
    public function money_format($string)
    {
        return number_format("$string", 2);
    }
    
    
    
    
    
    public function load_email_verification()
    {
        ob_start();
        if ($this->auth()->email_verification != 1) {
            require_once 'app/others/email_verification.php';
        }
        
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
    
    public function load_confirmation_dialog()
    {
        ob_start();
        require_once 'app/others/confirmation_dialog.php';
        
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
    
    
    
    
    public function load_phone_verification()
    {
        ob_start();
        require_once 'app/others/phone_verification.php';
        $output = ob_get_contents();
        ob_end_clean();
        
        return $output;
    }
    
    
    
    
    
    
    
    
    //protected function buildView($view, $data = null) {
    public function buildView($view, $data = null) {
        ob_start();
        $this->view($view, $data);
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
    
    
    protected function logout()
    {
        session_destroy();
        return true;
    }
    
    
    public function doLoginOTP($user, $password)
    {
        // print_r($_SESSION);
        
        
        Token::startNewOTPSession();
        Token::generateOTP();
        Token::requestOTP();
        
        $mailer = new Mailer();
        
        $recipient_name = $user->firstname;
        $subject        = $this->name . ' Login OTP';
        $body         = $this->buildView('emails/otp' , ['otp' => Token::requestOTP() , 'firstname' => $recipient_name ]);
        $to             = $user->email;
        $reply          = '';
        
        
        // Token
        
        $response = $mailer->sendMail($to, $subject, $body, $reply, $recipient_name);
        
        
        if ($response == true) {
            $this->redirect()->to($this->domain . '/login/otp')->go();
        }
        
        
    }
    
    
    protected function authenticate_with($email, $password){        
        $user = User::where('email', $email)->first();       

        if(password_verify($password, $user->password)) {
            Session::put($this->auth_user(), $user->login_id, $user->password);
            
            return $user;            
        } 
        else {            
            return false;
        }    
    }


    protected function authenticate_seller_with($email, $password){        
        $sellerAcc = Seller::where('email', $email)->first();       

        if(password_verify($password, $sellerAcc->password)) {
            Session::put($this->auth_seller(), $sellerAcc->seller_id, $sellerAcc->password);
            
            return $sellerAcc;
        } 
        else {            
            return false;
        }    
    }
    
    
    protected function authenticateAdmin_with($email, $password){
        $admin = Admin::where('email', $email)->first();        
        
        if (password_verify($password, $admin->password)) {
            Session::put($this->authAdmin(), $admin->id);
            return $admin;            
        } else {            
            return false;
        }    
    }
    
    
    public function auth_user(){
        return Config::project_name().str_replace('/', '', Config::userDirectory());
    }


    public function auth_seller(){
        return Config::project_name().str_replace('/', '', Config::sellerDirectory());
    }


    public function authAdmin(){
        return Config::project_name().str_replace('/', '', Config::adminDirectory());
    }
    
    public function admin(){
        if (Session::exist($this->authAdmin())) {
            return Admin::find(Session::get($this->authAdmin()));
        } else {            
            return false;
        }
    }
    
    public function auth(){
        if (Session::exist($this->auth_user())) {
            return User::find(Session::get($this->auth_user()));
        } else {            
            return false;
        }
    }


    public function authSeller(){
        if (Session::exist($this->auth_seller())) {
            return Seller::find(Session::get($this->auth_seller()));
        } else {            
            return false;
        }
    }
    
    
    public function model($model)
    {
        require_once 'app/models/' . $model . '.php';
        return new $model;
        
    }
    
    
    public function view($view, $data = [])
    {
        
        foreach ($data as $key => $value) {
            $$key = $value;
        }
        $view_path = explode('/', $view);
        array_pop($view_path);
        
        foreach ($view_path as $key => $folder) {
            
            $view_folder .= $folder . '/';
        }
        $view_folder = rtrim($view_folder, '/');
        
        
        $host          = Config::host();
        $project_name  = Config::project_name();
        $domain        = Config::domain();
        $asset         = $domain . "/" .Config::views_template(). "/auth";
        $this_folder   = $domain . "/" .Config::views_template().  "/$view_folder";
        $customFolder   = $domain . "/" .Config::views_template();
        $websocket_url = "$host:3000";
        
        
        define("domain", $domain, true);
        define("project_name", $project_name, true);
        define("$this_folder", $this_folder, true);
        define("$includes_dir", $includes_dir, true);
        define("accessor", $accessor, true);
        define("asset", $asset, true);
        define("websocket_url", $websocket_url, true);
        
        
        require_once Config::views_template() . "/{$view}.php";
        Session::delete('inputs-errors');
    }
    
    
    public function middleware($middleware)
    {
        
        require_once 'app/middlewares/' . $middleware . '.php';
        return new $middleware;
        
        
    }
    
    
    
    
}


?>