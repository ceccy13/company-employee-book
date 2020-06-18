<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class DataSplitOnPage
{
    private $pages = array();
    private $selected_page_interval = array();
	private $results_per_page = null;

    public function __construct($table, $results_per_page, $selected_page, $match)
    {
		$this->setResultPerPage($results_per_page);
		if(empty($selected_page)) $selected_page = 1;
        $this->set($table, $results_per_page, $match);      
        $this->setSelectedPageInterval($results_per_page, $selected_page);
    }

    public function set($table, $results_per_page, $match = null)
    {		
        $total_records = $this->countTableRecords($table, $match);
        $total_pages = ceil($total_records / $results_per_page);
        $addendTo = $total_records % $results_per_page;
        $page = 1;
        while($total_pages > 0){
            $from = $page * $results_per_page - $results_per_page + 1;
            $to = $page * $results_per_page;
			
            if ($total_pages == 1) $to = $total_records;
            $this->pages[$page]['start'] = $from;
            $this->pages[$page]['end'] = $to;
				
            $page++;
            $total_pages--;
        }
    }

    public function get()
    {
        return $this->pages;
    }

    public function setSelectedPageInterval($results_per_page, $selected_page)
    {
        $from = $selected_page * $results_per_page - $results_per_page;
        $to = $results_per_page;
        $this->selected_page_interval['from'] = $from;
        $this->selected_page_interval['to'] = $to;
    }

    public function getSelectedPageInterval()
    {
        return $this->selected_page_interval;
    }

    public function countTableRecords($table, $match)
    {
        if(Schema::hasTable($table)){
            return DB::table($table)
                ->where('name', 'like', '%'.$match.'%')
                ->count();
        }
        else{
            echo 'Table does not exist!';
        }
    }
	
	public function setResultPerPage($data){
		$this->results_per_page = $data;
	}

	public function getResultPerPage(){
		return $this->results_per_page;
	}

}
