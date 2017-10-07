<?php

namespace Modules\Menu\Services;

use Modules\Menu\Repositories\MenuItemRepository;
use Modules\Page\Repositories\PageRepository;

final class MenuItemUriGenerator
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
        $this->menuItem = $menuItem;
        $this->page = $page;
    }

    /**
     * Generate a URI based of the given page and and the parent id recursively
     * @param string $pageId
     * @param string $parentId
     * @param string $lang
     * @return string
     */
    public function generateUri($pageId, $parentId, $lang)
    {
        $linkPathArray = [];

        $linkPathArray[] = $this->getPageSlug($pageId, $lang);

        if ($parentId !== '') {
            $hasParentItem = !(is_null($parentId)) ? true : false;
            while ($hasParentItem) {
                $parentItemId = isset($parentItem) ? $parentItem->PARENT_ID : $parentId;
                $parentItem = $this->menuItem->find($parentItemId);

                if ((int) $parentItem->IS_ROOT === 0) {
                    if ($parentItem->PAGE_ID != '') {
                        $linkPathArray[] = $this->getPageSlug($parentItem->PAGE_ID, $lang);
                    } else {
                        $linkPathArray[] = $this->getParentUri($parentItem, $linkPathArray);
                    }
                    $hasParentItem = !is_null($parentItem->PARENT_ID) ? true : false;
                } else {
                    $hasParentItem = false;
                }
            }
        }
        $parentLinkPath = implode('/', array_reverse($linkPathArray));

        return $parentLinkPath;
    }

    /**
     * Get page slug
     * @param $id
     * @param $lang
     * @return string
     */
    private function getPageSlug($id, $lang)
    {
        $page = $this->page->find($id);

            return $page->SLUG;

    }

    /**
     * Get parent uri
     *
     * @params $pageId, $lang
     * @return string
     */
    private function getParentUri($item, $linkPathArray)
    {
        if ($item->URI === null) {
            return implode('/', $linkPathArray);
        }

        return $item->URI;
    }
}
