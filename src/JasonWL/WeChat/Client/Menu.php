<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 15-1-4
 * Time: 下午1:50
 */

namespace JasonWL\WeChat\Client;


class Menu extends Client
{
    /**
     * @param array $menuArr
     * @return mixed
     */
    public function create($menuArr)
    {
        $this->url(ApiList::MENU_CREATE)
            ->postParams = $menuArr;
        return $this->request();
    }

    public function getter()
    {
        $this->url(ApiList::MENU_GET);
        return $this->request();
    }

    public function delete()
    {
        $this->url(ApiList::MENU_DELETE);
        return $this->request();
    }
} 