<?php

namespace Modules\Menu\Entities;


use Illuminate\Database\Eloquent\Model;
use TypiCMS\NestableTrait;

class Menuitem extends Model
{
    use   NestableTrait;

    protected $primaryKey="ID";
    const CREATED_AT = 'IDATE';
    const UPDATED_AT = 'UDATE';
    protected $fillable = [
        'MENU_ID',
        'PAGE_ID',
        'PARENT_ID',
        'POSITION',
        'TARGET',
        'MODULE_NAME',
        'TITLE',
        'URI',
        'URL',
        'STATUS',
        'IS_ROOT',
        'ICON',
        'LINK_TYPE',
        'LOCALE',
        'CLASS',
    ];
    protected $table = 'menu_items';

    /**
     * For nested collection
     *
     * @var array
     */
    public $children = [];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    /**
     * Make the current menu item child of the given root item
     * @param Menuitem $rootItem
     */
    public function makeChildOf(Menuitem $rootItem)
    {
        $this->PARENT_ID = $rootItem->ID;
        $this->save();
    }

    /**
     * Check if the current menu item is the root
     * @return bool
     */
    public function isRoot()
    {
        return (bool) $this->IS_ROOT;
    }

    /**
     * Check if page_id is empty and returning null instead empty string
     * @return number
     */
    public function setPageIdAttribute($value)
    {
        $this->attributes['PAGE_ID'] = ! empty($value) ? $value : null;
    }

    /**
     * Check if parent_id is empty and returning null instead empty string
     * @return number
     */
    public function setParentIdAttribute($value)
    {
        $this->attributes['PARENT_ID'] = ! empty($value) ? $value : null;
    }
}
