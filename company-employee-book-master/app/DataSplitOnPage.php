<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class DataSplitOnPage
{
    private $pages = array();
    private $results_per_page;
    private $selected_page = 1;
    private $selected_page_interval = array();

    public function __construct($table, $results_per_page, $selected_page, $match){
        $this->results_per_page = $results_per_page;
        $this->set($table, $results_per_page, $match);

        if(!empty($selected_page)) $this->selected_page = $selected_page;
        $this->setSelectedPageInterval($this->selected_page);
    }

    public function set($table, $results_per_page, $match = null){
        $total_records = $this->countTableRecords($table, $match);
        $total_pages = ceil($total_records / $results_per_page);
        $addendTo = $total_records % $results_per_page;
        $page = 1;
        while($total_pages > 0){
            $from = $page * $results_per_page - $results_per_page + 1;
            $to = $page * $results_per_page;
            if ($total_pages == 1 && $addendTo != 0) $to = $from + $addendTo - 1;
            $this->pages[$page]['start'] = $from;
            $this->pages[$page]['end'] = $to;

            $page++;
            $total_pages--;
        }
    }

    public function get(){
        return $this->pages;
    }

    public function setSelectedPageInterval($selected_page){
        $from = $selected_page * $this->results_per_page - $this->results_per_page + 1;
        $to = $selected_page * $this->results_per_page;
        $this->selected_page_interval['from'] = $from;
        $this->selected_page_interval['to'] = $to;
    }

    public function getSelectedPageInterval(){
        return $this->selected_page_interval;
    }

    public function countTableRecords($table, $match){
        if(Schema::hasTable($table)){
            return DB::table($table)
                ->where('name', 'like', '%'.$match.'%')
                ->count();
        }
        else{
            echo 'Table does not exist!';
            return;
        }

    }

}
