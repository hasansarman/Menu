<?php

namespace Modules\Menu\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Menu\Events\MenuItemIsCreating;
use Modules\Menu\Events\MenuItemIsUpdating;
use Modules\Menu\Events\MenuItemWasCreated;
use Modules\Menu\Events\MenuItemWasUpdated;
use Modules\Menu\Repositories\MenuItemRepository;
use  Modules\Menu\Entities\MenuItem;
use  Modules\Menu\Entities\Menu;
use Illuminate\Support\Facades\Log;
class EloquentMenuItemRepository extends EloquentBaseRepository implements MenuItemRepository
{
//protected $model=MenuItem::class;
    public function create($data)
    {
    //  print_r($this->model::all());
        event($event = new MenuItemIsCreating($data));
        $menuItem = $this->model->create($event->getAttributes());

        event(new MenuItemWasCreated($menuItem));

        return $menuItem;
    }

    public function update($menuItem, $data)
    {
      Log::error("menuitemrepo ".json_encode($menuItem));
        event($event = new MenuItemIsUpdating($menuItem, $data));
        $menuItem->update($event->getAttributes());

        event(new MenuItemWasUpdated($menuItem));

        return $menuItem;
    }

    /**
     * Get online root elements
     *
     * @param  int    $menuId
     * @return object
     */
    public function rootsForMenu($menuId)
    {
        return $this->model->where(['STATUS'=> 1,'MENU_ID'=>$menuId])->orderBy('POSITION')->get();
    }

    /**
     * Get all root elements
     *
     * @param  int    $menuId
     * @return object
     */
    public function allRootsForMenu($menuId)
    {
        return $this->model-> where(['MENU_ID'=>$menuId])->orderBy('PARENT_ID')->orderBy('POSITION')->get();
    }

    /**
     * Get Items to build routes
     *
     * @return Array
     */
    public function getForRoutes()
    {
        $menuitems = DB::table('menus')
            ->select(
                'PRIMARY',
                'menu_items.ID',
                'menu_items.PARENT_ID',
                'menu_items.MODULE_NAME'
            )
            ->join('menu_items', 'menus.ID', '=', 'menu_items.MENU_ID')

            ->where('URI', '!=', '')
            ->where('MODULE_NAME', '!=', '')
            ->where('STATUS', '=', 1)
            ->where('PRIMARY', '=', 1)
            ->orderBy('MODULE_NAME')
            ->get();

        $menuitemsArray = [];
        foreach ($menuitems as $menuitem) {
            $menuitemsArray[$menuitem->MODULE_NAME][$menuitem->LOCALE] = $menuitem->URI;
        }

        return $menuitemsArray;
    }

    /**
     * Get the root menu item for the given menu id
     *
     * @param  int    $menuId
     * @return object
     */
    public function getRootForMenu($menuId)
    {
        return $this->model->where(['MENU_ID' => $menuId, 'IS_ROOT' => true])->firstOrFail();
    }

    /**
     * Return a complete tree for the given menu id
     *
     * @param  int    $menuId
     * @return object
     */
    public function getTreeForMenu($menuId)
    {
        $items = $this->rootsForMenu($menuId);

        return $items->nest();
    }

    /**
     * @param  string $uri
     * @param  string $locale
     * @return object
     */
    public function findByUriInLanguage($uri, $locale)
    {
        return $this->model->where(['STATUS'=> 1,'URI'=> $uri])->first();
  }
}
