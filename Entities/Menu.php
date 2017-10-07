<?php

namespace Modules\Menu\Entities;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{

  protected $primaryKey="ID";
  const CREATED_AT = 'IDATE';
  const UPDATED_AT = 'UDATE';
    protected $fillable = [
        'NAME',
        'TITLE',
        'STATUS',
        'PRIMARY',
    ];

    protected $table = 'menus';

    public function menuitems()
    {
        return $this->hasMany('Modules\Menu\Entities\Menuitem')->orderBy('position', 'asc');
    }
}
