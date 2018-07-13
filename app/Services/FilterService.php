<?php

namespace App\Services;

use Patagona\Pricemonitor\Core\Sync\Filter\Filter;
use Patagona\Pricemonitor\Core\Sync\Filter\FilterRepository;
use Patagona\Pricemonitor\Core\Sync\Filter\Group;
use Patagona\Pricemonitor\Core\Sync\TransactionHistory\TransactionHistoryType;
use Patagona\Pricemonitor\Core\Sync\Filter\Expression;

class FilterService
{
      /**
     * Allowed operators
     *
     * @var array
     */
    public static $operators = array('OR', 'AND');

    /**
     * Allowed filter types
     *
     * @var array
     */
    public static $types = array(
        TransactionHistoryType::EXPORT_PRODUCTS,
        TransactionHistoryType::IMPORT_PRICES
    );


    /**
     * Gets filter by provided filter type and Pricemonitor ID.
     *
     * @param string $filterType Types defined in $types static variable
     * @param string $pricemonitorId Pricemonitor Contract ID
     *
     * @return array
     */
    public function getFilter($filterType, $pricemonitorId)
    {
        $result = array('type' => $filterType, 'filters' => array());
        $filterRepository = new FilterRepository();
        $filter = $filterRepository->getFilter($pricemonitorId, $filterType);

        if ($filter === null) {
            return $result;
        }

        /** @var Group $group */
        foreach ($filter->getExpressions() as $group) {
            $current = array(
                'name' => $group->getName(),
                'groupOperator' => $group->getOperator(),
                'expressions' => array()
            );

            /** @var Expression $expression */
            foreach ($group->getExpressions() as $expression) {
                $current['operator'] = $expression->getOperator();
                $current['expressions'][] = array(
                    'code' => $expression->getField(),
                    'condition' => $expression->getCondition(),
                    'type' => $expression->getValueType(),
                    'value' => $expression->getValues(),
                );
            }

            $result['filters'][] = $current;
        }

        return $result;
    }

    /**
     * Saves filter using filter Pricemonitor core filter repository.
     *
     * @param array $filterData
     * @param string $filterType
     * @param string $pricemonitorId
     *
     * @return Filter
     */
    public function saveFilter($filterData, $filterType, $pricemonitorId)
    {
        $filter = $this->getPopulatedFilter($filterData, $filterType);

        $filterRepository = new FilterRepository();
        $filterRepository->saveFilter($pricemonitorId, $filter);

        return $filter;
    }

       /**
     * Populates filter object with provided filter data and filter type.
     *
     * @param array $filterData
     * @param string $filterType
     *
     * @return Filter
     */
    public function getPopulatedFilter($filterData, $filterType)
    {
        $filterGroups = array();
        foreach ($filterData as $key => $filterGroup) {
            if (empty($filterGroup['expressions'])) {
                continue;
            }

            $name = isset($filterGroup['name']) ? $filterGroup['name'] : ('Group ' . (++$key));
            $group = new Group($name, $filterGroup['groupOperator']);

            $expressions = array();
            foreach ($filterGroup['expressions'] as $expression) {
                $expressions[] = new Expression(
                    $expression['code'],
                    $expression['condition'],
                    $expression['type'],
                    $expression['value'],
                    $filterGroup['operator']
                );
            }

            $group->setExpressions($expressions);
            $filterGroups[] = $group;
        }

        $filter = new Filter('Filter', $filterType);
        $filter->setExpressions($filterGroups);
        return $filter;
    }
    
    public function getFilteredVariations($filter, $pricemonitorId, $allVariations,$attributesFromPlenty)
    {
        $filterRepository = new FilterRepository();
      //  $filter = $filterRepository->getFilter($pricemonitorId, $filterType);

        $finalProductCollection = null;
        $parentGroup = [];
        $groupFilter = [];

        foreach ($filter->getExpressions() as $group) {
            $operator = null;
            $expressions = array();

            foreach ($group->getExpressions() as $expression) {
                $condition = $expression->getCondition();

                $field = $expression->getField();
                $values = $expression->getValues();
                $operator = $expression->getOperator();

                $expressions[] = array(
                    'attribute' => $field,
                    'values' => $values,
                    'condition' => $condition,
                    'operator' => $operator
                );
            }

            $groupFilter['expressions'] =  $expressions;
            $groupFilter['operator'] =  $group->getOperator();

            array_push($parentGroup,$groupFilter);
        }
   
        if (!empty($parentGroup)) {
            $productCollection = $this->addFilterByOperator($parentGroup, $group->getOperator(),$allVariations,$attributesFromPlenty);
        }

        return $productCollection;
    }

    public function addFilterByOperator($parentGroup,$groupOperator,$variationArray,$attributesFromPlenty) 
    {
        try {
            
            $finalFilteredProduct = array();
          
            $parentFilteredGroup = [];
            $filteredGroup = [];

            foreach($parentGroup as $group)
            {
               $filterVAriationByConditions = [];

                foreach($group["expressions"] as $exp) {
                    $operator = $exp['operator'];
                    $values = $exp['values'];
                    $attribute = $exp['attribute'];
                    $condition = $exp['condition'];
    
                    $filterByColumn = $attributesFromPlenty[$attribute]; 
    
                    switch($attribute) {
    
                        case "Category" :
                            $filterByColumn = "category-".$values[0];
                        break;
                        case "Manufacturer" :
                             $filterByColumn = "manufacturer-".$values[0];
                        break;
                        case "Supplier" :
                              $filterByColumn = "supplier-".$values[0];
                        break;
    
                        default :
                            $filterByColumn = $attributesFromPlenty[$attribute]; 
                    }
        
                    $nameColumnInVariation = null;
    
                    switch($condition) {
    
                        case "equal" :
                            $filterVAriationByConditions [] =  ["filterByColumn" => $filterByColumn,
                                                                "value" => $values[0],
                                                                "condition" => "=",
                                                                "operator" =>  $operator];
                        break;
                        case "not_equal" :
                            $filterVAriationByConditions [] =  ["filterByColumn" => $filterByColumn,
                                                                "value" => $values[0],
                                                                "condition" => "!=",
                                                                "operator" =>  $operator];
                        break;
                        case "greater_than" :
                            $filterVAriationByConditions [] =  ["filterByColumn" => $filterByColumn,
                                                                "value" => $values[0],
                                                                "condition" => ">",
                                                                "operator" =>  $operator];
                        break;
                        case "less_than" :
                            $filterVAriationByConditions [] =  ["filterByColumn" => $filterByColumn,
                                                                "value" => $values[0],
                                                                "condition" => "<",
                                                                "operator" =>  $operator];
                        break;
                        case "greater_or_equal" :
                            $filterVAriationByConditions [] =  ["filterByColumn" => $filterByColumn,
                                                                "value" => $values[0],
                                                                "condition" => ">=",
                                                                "operator" =>  $operator];
                        break;
                        case "less_or_equal" :
                            $filterVAriationByConditions [] =  ["filterByColumn" => $filterByColumn,
                                                                "value" => $values[0],
                                                                "condition" => "<=",
                                                                "operator" =>  $operator];
                        break;
                        case "contains" :
                            $filterVAriationByConditions [] =  ["filterByColumn" => $filterByColumn,
                                                                "value" => $values[0],
                                                                "condition" => "stripos!=",
                                                                "operator" =>  $operator];
                        break;
                        case "contains_not" :
                        $filterVAriationByConditions [] =  ["filterByColumn" => $filterByColumn,
                                                            "value" => $values[0],
                                                            "condition" => "stripos==",
                                                            "operator" =>  $operator];
                        break;
                    }
                }

                $filteredGroup['expressionFilter'] =  $filterVAriationByConditions;
                $filteredGroup['operator'] = $group["operator"];
                array_push($parentFilteredGroup,$filteredGroup);   
            } 

            $filteredProducts = array_filter($variationArray, function($value) use ($filterVAriationByConditions, $parentFilteredGroup) {

                $groupCondition = null;
                foreach($parentFilteredGroup as $filterGroup) 
                {
                    $condition = null;
                    foreach($filterGroup["expressionFilter"] as $variationCondition) {

                        $filterByCondition = $variationCondition["condition"];
                        
                        switch($filterByCondition) {
    
                            case "=" :                               
                                    if($condition !== null) {
                                        if($variationCondition["operator"] === "AND")
                                        {
                                            if(isset($value[$variationCondition["filterByColumn"]])) 
                                                $condition = $condition && ($value[$variationCondition["filterByColumn"]] === $variationCondition["value"]);
                                            else 
                                                $condition = $condition &&  false;
                                        }
                                        else if($variationCondition["operator"] === "OR")
                                        {
                                            if(isset($value[$variationCondition["filterByColumn"]])) 
                                                $condition = $condition || $value[$variationCondition["filterByColumn"]] === $variationCondition["value"];
                                            else 
                                                $condition = $condition ||  false;
                                        }
                                    } else {
                                        if(isset($value[$variationCondition["filterByColumn"]])) 
                                            $condition = ($value[$variationCondition["filterByColumn"]] === $variationCondition["value"]);
                                        else 
                                            $condition = false;   
                                    }
                                 
                               break;
                            case "!=" :
                              if(isset($value[$variationCondition["filterByColumn"]])) 
                              {
                                    if($condition !== null) {
                                        if($variationCondition["operator"] == "AND")
                                            $condition = $condition && $value[$variationCondition["filterByColumn"]] != $variationCondition["value"];
                                        else if($variationCondition["operator"] == "OR")
                                            $condition = $condition || $value[$variationCondition["filterByColumn"]] != $variationCondition["value"];
                                    } else
                                        $condition = $value[$variationCondition["filterByColumn"]] != $variationCondition["value"];
                                }
                            break;
                            case ">" :
                            if(isset($value[$variationCondition["filterByColumn"]])) 
                            {
                               if($condition !== null) {
                                 if($variationCondition["operator"] == "AND")
                                    $condition = $condition && $value[$variationCondition["filterByColumn"]] > $variationCondition["value"];
                                 else if($variationCondition["operator"] == "OR")
                                     $condition = $condition || $value[$variationCondition["filterByColumn"]] > $variationCondition["value"];
                                } else
                                    $condition =  $value[$variationCondition["filterByColumn"]] > $variationCondition["value"];
                            }
                            break;
                            case "<" :
                            if(isset($value[$variationCondition["filterByColumn"]])) 
                            {
                              if($condition !== null) {
                                  if($variationCondition["operator"] == "AND")
                                     $condition = $condition && $value[$variationCondition["filterByColumn"]] < $variationCondition["value"];
                                  else if($variationCondition["operator"] == "OR")
                                     $condition = $condition || $value[$variationCondition["filterByColumn"]] < $variationCondition["value"];
                               } else
                                     $condition = $value[$variationCondition["filterByColumn"]] < $variationCondition["value"];
                             }
                              break;
                            case ">=" :
                            if(isset($value[$variationCondition["filterByColumn"]])) 
                            {
                                if($condition !== null) {
                                    if($variationCondition["operator"] == "AND")
                                        $condition = $condition && $value[$variationCondition["filterByColumn"]] >= $variationCondition["value"];
                                   else if($variationCondition["operator"] == "OR")
                                        $condition = $condition || $value[$variationCondition["filterByColumn"]] >= $variationCondition["value"];
                                } else 
                                    $condition = $value[$variationCondition["filterByColumn"]] >= $variationCondition["value"];
                            }
                            break;
                            case "<=" :
                            if(isset($value[$variationCondition["filterByColumn"]])) 
                            {
                                if($condition !== null) {
                                    if($variationCondition["operator"] == "AND")
                                        $condition = $condition && $value[$variationCondition["filterByColumn"]] <= $variationCondition["value"];
                                    else if($variationCondition["operator"] == "OR")
                                        $condition = $condition || $value[$variationCondition["filterByColumn"]] <= $variationCondition["value"];
                                  } else
                                    $condition = $value[$variationCondition["filterByColumn"]] <= $variationCondition["value"];
                            }
                             break;
                            case "stripos!=" :
                            if(isset($value[$variationCondition["filterByColumn"]])) 
                            {
                                if($condition !== null) {                                
                                    if($variationCondition["operator"] == "AND")
                                        $condition =  $condition && (stripos($value[$variationCondition["filterByColumn"]]) !== false);
                                    else if($variationCondition["operator"] == "OR")
                                        $condition =  $condition || (stripos($value[$variationCondition["filterByColumn"]]) !== false);
                                } else
                                    $condition = (stripos($value[$variationCondition["filterByColumn"]]) !== false);
                             }
                              break;
                            case "stripos==" :
                            if(isset($value[$variationCondition["filterByColumn"]])) 
                            {
                                if($condition !== null) {
                                    if($variationCondition["operator"] == "AND")
                                        $condition =  $condition && (stripos($value[$variationCondition["filterByColumn"]]) === false);
                                     else if($variationCondition["operator"] == "OR")
                                        $condition =  $condition || (stripos($value[$variationCondition["filterByColumn"]]) === false);
                                } else
                                    $condition =  (stripos($value[$variationCondition["filterByColumn"]]) === false);
                            }
                            break;
                        }
                    }
                   
                    $operatorGroup = $filterGroup["operator"];
                    if($operatorGroup == "AND")
                        $groupCondition = $groupCondition === null ? ($condition) : $groupCondition && ($condition);
                    else if($operatorGroup == "OR")
                        $groupCondition = $groupCondition === null ? ($condition) : $groupCondition || ($condition);

                }                

                return $groupCondition;                    
            });
    
             return  array_values($filteredProducts);

        } catch (\Exception $ex)
        {
            $response = [
                'Code' => $ex->getCode(),
                'Message' => $ex->getMessage()
             ];

             return $response;

        }      
    }
}

?>