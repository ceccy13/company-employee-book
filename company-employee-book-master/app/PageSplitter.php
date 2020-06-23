<?php

namespace App;

use Illuminate\Support\Facades\DB;

class PageSplitter
{
    private $pages = array();
    private $records_per_page = null;
    private $page = null;
    private $page_from = null;
    private $page_to = null;

    public function __construct($records_total, $records_per_page, $page_selected)
    {
        if(empty($page_selected)) $page_selected = 1;
        $this->setPages($records_total, $records_per_page);
        $this->setPageInterval($records_per_page, $page_selected);
        $this->setNumberRecordsPerPage($records_per_page);
    }

    public function setPages($records_total, $records_per_page)
    {
        $total_records = $records_total;
        $total_pages = ceil($total_records / $records_per_page);
        $addendTo = $total_records % $records_per_page;
        $page = 1;
        while($total_pages > 0){
            $from = $page * $records_per_page - $records_per_page + 1;
            $to = $page * $records_per_page;
            if ($total_pages == 1 && $addendTo != 0) $to = $total_records;
            $this->pages[$page]['start'] = $from;
            $this->pages[$page]['end'] = $to;

            $page++;
            $total_pages--;
        }
    }

    public function getPages()
    {
        return $this->pages;
    }

    public function setPageInterval($records_per_page, $page_selected)
    {
        $from = $page_selected * $records_per_page - $records_per_page;
        $to = $records_per_page;
        $this->page_from = $from;
        $this->page_to = $to;
    }

    public function getPageFrom(){
        return $this->page_from;
    }

    public function getPageTo(){
        return $this->page_to;
    }

    public function setNumberRecordsPerPage($data){
        $this->records_per_page = $data;
    }

    public function getNumberRecordsPerPage(){
        return $this->records_per_page;
    }

}
