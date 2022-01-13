<?php
/**
 * Created by PhpStorm.
 * User: paul
 * Date: 22.12.2021
 * Time: 10:12
 */

namespace App\allClass\helpers;

class GridPaginateOrderFilter {

	private $requestPaginate = null;
	private $requestFilter   = null;
	private $requestOrder    = null;

	public function __construct($request) {

		$this->requestPaginate = $request->paginate;
		$this->requestFilter   = $request->filterBy;
		$this->requestOrder    = $request->orderBy;

	}

	public function getFilter(){
		// if($this->requestFilter['newFilter']){

		$where = '';
		foreach ($this->requestFilter['header'] as $key => $value){
			if($value["filterString"] != null) {
				$where .= $value["fieldName"] . " like '%" . $value["filterString"] . "%' and "  ;
			}
		}

		// remove last and
		if(!empty($where)) {
			$where = "(" . rtrim($where, ' and ') . ")";
		}

		return $where ;
	}

	public function getOrder(){
		$sqlOrder = $this->requestOrder['fieldName'] . ' ' . $this->requestOrder['order'];
		return $sqlOrder;

	}

	public function getPaginate(){
		$this->requestPaginate['offsetPage'] = ($this->requestPaginate['pageNumber']-1) * $this->requestPaginate['perPage'];
		return $this->requestPaginate;
	}


}