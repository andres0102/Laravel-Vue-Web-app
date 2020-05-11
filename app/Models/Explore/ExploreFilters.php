<?php
/**
 * Created by PhpStorm.
 * User: a1
 * Date: 2019-06-18
 * Time: 17:20
 */

namespace App\Models\Explore;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ExploreFilters extends  Model
{
    protected $table = 'explore_filters_to_items';

    public function getFilterName(){
        $filterValue = Db::table('explore_filters_value')->where('id',$this->filter_value_id)->first();
        return $filterValue->value;
    }

    public function getFilterGroupName(){
        $filterValue = Db::table('explore_filters_value')->where('id',$this->filter_value_id)->first();
        $filterGroup = Db::table('explore_filters')->where('id',$filterValue->filter_id)->first();
        return $filterGroup->name;
    }
    /**
     * return filters values
    * @param array $categoriesIds - id of categories
    * @param array $itemIds - id of clients
    * @return array
     */
    public static function getFilters(array $categoriesIds = [], array $itemIds = []){
        $filters=[];
        $filtersValueCategories = '';
        $filtersValueClients = '';
        if(!empty($categoriesIds)){
            $filtersValueCategories = ExploreFilters::whereIn('cat_id',$categoriesIds)->distinct('filter_value_id')->get();

        }
        if(!empty($itemIds)){
            $filtersValueClients = ExploreFilters::whereIn('client_id',$itemIds)->distinct('filter_value_id')->get();
        }
        if($filtersValueCategories)
            foreach ($filtersValueCategories as $filterVal){
                $filterName = $filterVal->getFilterName();
                $filterGroup = $filterVal->getFilterGroupName();
                $filters[$filterGroup][$filterVal->filter_value_id]=$filterName;
            }
        if($filtersValueClients)
            foreach ($filtersValueClients as $filterVal){
                $filterName = $filterVal->getFilterName();
                $filterGroup = $filterVal->getFilterGroupName();
                $filters[$filterGroup][$filterVal->filter_value_id]=$filterName;
            }
        return $filters;

    }

}
