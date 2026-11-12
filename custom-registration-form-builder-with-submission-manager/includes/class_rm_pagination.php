<?php

class RM_Pagination {

    public $total_pages;
    public $entries_per_page;
    public $curr_page;
    public $offset;
    public $html;
    public $filters;
    public $query_string;
    public $page;
    public $page_query_arg;

    public function __construct($filters,$page,$total_entries = 0, $req_page = 0, $entries_per_page = 10, $page_query_arg = 'rm_reqpage') {
        $this->entries_per_page = $entries_per_page;
        $this->offset =  ($req_page - 1) * $this->entries_per_page;
        $this->total_pages = (int) ($total_entries / $this->entries_per_page) + (($total_entries % $this->entries_per_page) == 0 ? 0 : 1);
        $this->curr_page = $req_page;
        $this->filters= $filters;
        $this->page= $page;
        $this->page_query_arg = is_string($page_query_arg) && preg_match('/^[A-Za-z0-9_]+$/', $page_query_arg) ? $page_query_arg : 'rm_reqpage';
        
        $this->create_query_string();
    }

    public function render($max_pages_without_abb=10,$max_visible_pages_near_current_page=3) {
        $next_page= $this->curr_page+1; 
        $last_page= $this->total_pages;
        if ($this->total_pages > 1):
            $this->html .= '<ul class="rmpagination">';

            if ($this->curr_page > 1):
                $this->html .= '<li><a href="'.$this->query_string.'&'.$this->page_query_arg.'=1">' . RM_UI_Strings::get('LABEL_FIRST') . '</a></li>'.
                               '<li><a href="'.$this->query_string.'&'.$this->page_query_arg.'='.($this->curr_page-1).'">' . RM_UI_Strings::get('LABEL_PREVIOUS') . '</a></li>';
            endif;

            if ($this->total_pages > $max_pages_without_abb):
                if ($this->curr_page > $max_visible_pages_near_current_page + 1):
                    $this->html .= '<li><a> ... </a></li>';
                    $first_visible_page = $this->curr_page - $max_visible_pages_near_current_page;
                else:
                    $first_visible_page = 1;
                endif;

                if ($this->curr_page < $this->total_pages - $max_visible_pages_near_current_page):
                    $last_visible_page = $this->curr_page + $max_visible_pages_near_current_page;
                else:
                    $last_visible_page = $this->total_pages;
                endif;
            else:
                $first_visible_page = 1;
                $last_visible_page = $this->total_pages;
            endif;
           
            for ($i = $first_visible_page; $i <= $last_visible_page; $i++):
                if ($i != $this->curr_page):
                    $this->html .= '<li><a href="'.$this->query_string.'&'.$this->page_query_arg.'='.$i.'">'.$i.'</a></li>';
                else:
                    $this->html .= '<li><a class="active" href="'.$this->query_string.'&'.$this->page_query_arg.'=' . $i . '">' . $i . '</a></li>';
                endif;
                
            endfor;
            
            if ($this->total_pages > $max_pages_without_abb):
                if ($this->curr_page < $this->total_pages - $max_visible_pages_near_current_page):
                    $this->html .= '<li><a> ... </a></li>';
                endif;
            endif;

            if ($this->curr_page < $this->total_pages):
                $this->html .= '<li><a href="'.$this->query_string.'&'.$this->page_query_arg.'='.$next_page.'">' . RM_UI_Strings::get('LABEL_NEXT') . '</a></li>' .
                        '<li><a href="'.$this->query_string.'&'.$this->page_query_arg.'='.$last_page.'">' . RM_UI_Strings::get('LABEL_LAST') . '</a></li>';
            endif;

            $this->html .='</ul>';
        endif;
        
        return $this->html;
    }
   
   public function create_query_string(){
        $this->query_string = "?page=".$this->page;
        
        if(!empty($this->filters) && is_array($this->filters)){
            foreach($this->filters as $key=>$val){
                $this->query_string .= '&'.$key.'='.$val;
            }
        }
    }
    
   public function set_total_entries($total_entries){
        $this->total_pages = (int) ($total_entries / $this->entries_per_page) + (($total_entries % $this->entries_per_page) == 0 ? 0 : 1);
   } 
}

