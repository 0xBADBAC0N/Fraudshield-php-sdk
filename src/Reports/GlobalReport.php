<?php

namespace Fraudshield\Reports;

use Exception;

class GlobalReport extends Report
{
    protected $dataSources;
    protected $filters;
    protected $extraFilters;

    const END_POINT = "reports/global.json";
    const MAX_DATA_SOURCES = 4;
    const VALID_DATA_SOURCES = ['tracker_id', 'affiliate', 'partner', 'product', 'sub_id', 'country_code'];
    const VALID_FILTERS = ['tracker_id'];

    public function __construct($dateStart = null, $dateEnd = null, $timezone = null)
    {
        $this->setStartDate($dateStart);
        $this->setEndDate($dateEnd);
        $this->timezone = $timezone;
        $this->initializeDefaults();
    }

    protected function prepareParameters()
    {
        $group= [];
        foreach ($this->dataSources as $ds) {
            $group[] = $ds;
        }
        if (count($group) > 0) {
           $this->parameters['group'] = $group; 
        }

        $search_fields= [];
        foreach ($this->filters as $filter => $value) {
            $search_fields[] = json_encode(["term" => $filter, "query" => $value]);
        }
        if (count($search_fields) > 0) {
           $this->parameters['search_fields'] = $search_fields; 
        }

        $this->parameters['date_start'] = $this->dateStart;
        $this->parameters['date_end'] = $this->dateEnd;
        $this->parameters['timezone'] = $this->timezone;
        
        return $this;
    }

    protected function initializeDefaults()
    {
        $this->initializeDefaultDate();

        $this->dataSources = ['tracker_id'];
        $this->filters = [];
        $this->extraFilters= [];
    }

    
}