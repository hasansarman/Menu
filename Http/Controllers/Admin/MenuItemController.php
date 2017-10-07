<?php

namespace Modules\Menu\Http\Controllers\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Laracasts\Flash\Flash;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Menu\Entities\Menu;
use Modules\Menu\Entities\Menuitem;
use Modules\Menu\Http\Requests\CreateMenuItemRequest;
use Modules\Menu\Http\Requests\UpdateMenuItemRequest;
use Modules\Menu\Repositories\MenuItemRepository;
use Modules\Page\Repositories\PageRepository;
use Illuminate\Support\Facades\Log;
class MenuItemController extends AdminBaseController
{
    /**
     * @var MenuItemRepository
     */
    private $menuItem;
    /**
     * @var PageRepository
     */
    private $page;
    public function __construct(MenuItemRepository $menuItem, PageRepository $page)
    {
        parent::__construct();
        $this->menuItem = $menuItem;
        $this->page = $page;
    }
    public function create(Menu $menu)
    {
        $pages = $this->page->all();
        return view('menu::admin.menuitems.create', compact('menu', 'pages'));
    }
    public function store(Menu $menu, CreateMenuItemRequest $request)
    {
        $this->menuItem->create($this->addMenuId($menu, $request));
      //  flash(trans('menu::messages.menuitem created'));
        return redirect()->route('admin.menu.menu.edit', [$menu->ID]);
    }
    public function edit(Menu $menu, Menuitem $menuItem)
    {
        $pages = $this->page->all();
        return view('menu::admin.menuitems.edit', compact('menu', 'menuItem', 'pages'));
    }
    public function update(Menu $menu, Menuitem $menuItem, UpdateMenuItemRequest $request)
    {
      Log::error("menuitemcontoller ".json_encode($menu)."           ".json_encode($menuItem));
        $this->menuItem->update($menuItem, $this->addMenuId($menu, $request));
      //  flash(trans('menu::messages.menuitem updated'));
        return redirect()->route('admin.menu.menu.edit', [$menu->ID]);
    }
    public function destroy(Menu $menu, Menuitem $menuItem)
    {
        $this->menuItem->destroy($menuItem);
      //  flash(trans('menu::messages.menuitem deleted'));
        return redirect()->route('admin.menu.menu.edit', [$menu->ID]);
    }
    /**
     * @param  Menu                                    $menu
     * @param  \Illuminate\Foundation\Http\FormRequest $request
     * @return array
     */
    private function addMenuId(Menu $menu, FormRequest $request)
    {

        return array_merge($request->all(), ['MENU_ID' => $menu->ID]);
    }
}
