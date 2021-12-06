 <?php

/**
 * 
 */
class operations
{
    
    
    
    
    public function pagination_links($data, $per_page)
    {
        $no_of_pages = ceil((count($data)) / $per_page);
        
        
        $current_page = (isset($_GET['page'])) ? $_GET['page'] : 1;
        
        $page_prev = ($current_page == 1 || (!isset($current_page))) ? 1 : ($current_page - 1);
        $page_next = ($current_page == $no_of_pages) ? $no_of_pages : ($current_page + 1);
        
        
        $prev_page = "<li class='page-item'><a class='page-link' href='?page=$page_prev'>Prev</a></li>";
        $next_page = "<li class='page-item'><a class='page-link' href='?page=$page_next'>Next</a></li>";
        
        
        for ($i = 1; $i <= $no_of_pages; $i++) {
            
            if ($current_page == $i) {
                $active = 'active';
            } elseif (!isset($current_page) && ($i == 1)) {
                $active = 'active';
            } else {
                $active = '';
            }
            
            $link .= "<li class='page-item $active'><a class='page-link' href='?page=$i'>$i</a></li>";
            
            
        }
        
        $link = $prev_page . $link . $next_page;
        return $link;
        
    }
    
    
    
    
    
    public function pictures()
    {
        
        $dir  = 'public/img/upload/';
        $file = scandir($dir);
        unset($file[0]);
        unset($file[1]);
        
        return $file;
        
    }
    
    
    
    public function strip($string)
    {
        return trim(strip_tags("$string"));
    }
    
    public function encode_for_url($string)
    {
        return str_replace(' ', '-', $string);
    }
    
    
    public function decode_url($string)
    {
        $string = str_replace('-', ' ', $string);
        $string = str_replace('_', ' ', $string);
        return $string;
    }
    
    
    
    public function flash($message, $message_type)
    {
        
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        $notice = array(
            'type' => $message_type,
            'message' => $message
        );
        print_r(json_encode($notice));
        
        
    }
    
    
    
    
    
}


?> 