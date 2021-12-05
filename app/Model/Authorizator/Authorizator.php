<?php

namespace App\Model\Authorizator;

use App\Model\Entities\Attribute;
use App\Model\Entities\Category;
use App\Model\Entities\Permission;
use App\Model\Entities\Product;
use App\Model\Entities\Value;
use App\Model\Facades\UsersFacade;

class Authorizator extends \Nette\Security\Permission
{
    public function __construct(UsersFacade $usersFacade)
    {
        foreach ($usersFacade->findResources() as $resource) {
            $this->addResource($resource->id);
        }

        foreach ($usersFacade->findRoles() as $role) {
            $this->addRole($role->id);
        }

        foreach ($usersFacade->findPermissions() as $permission) {
            if ($permission->type == Permission::TYPE_ALLOW) {
                $this->allow($permission->roleId, $permission->resourceId, $permission->action ? $permission->action : null);
            } else {
                $this->deny($permission->roleId, $permission->resourceId, $permission->action ? $permission->action : null);
            }
        }
    }

    public function isAllowed($role = self::ALL, $resource = self::ALL, $privilege = self::ALL): bool
    {
        if ($resource instanceof Category) {
            return $this->categoryResourceIsAllowed($role, $resource, $privilege);
        }

        if ($resource instanceof Product) {
            return $this->productResourceIsAllowed($role, $resource, $privilege);
        }

        if ($resource instanceof Attribute) {
            return $this->attributeResourceIsAllowed($role, $resource, $privilege);
        }

        if ($resource instanceof Value) {
            return $this->valueResourceIsAllowed($role, $resource, $privilege);
        }

        return parent::isAllowed($role, $resource, $privilege);
    }

    private function categoryResourceIsAllowed($role, Category $resource, $privilege)
    {
        switch ($privilege) {
            case 'delete':
                //TODO kontrola, jestli jsou v kategorii nějaké produkty - pokud ano, nesmažeme ji
        }

        return parent::isAllowed($role, 'Category', $privilege);
    }

    private function productResourceIsAllowed($role, Product $resource, $privilege)
    {
        switch ($privilege) {
            case 'delete':
                //TODO kontrola, jestli jsou v kategorii nějaké produkty - pokud ano, nesmažeme ji
        }

        return parent::isAllowed($role, 'Product', $privilege);
    }

    private function attributeResourceIsAllowed($role, Attribute $resource, $privilege)
    {
        switch ($privilege) {
            case 'delete':
                //TODO kontrola, jestli jsou v kategorii nějaké produkty - pokud ano, nesmažeme ji
        }

        return parent::isAllowed($role, 'Attribute', $privilege);
    }

    private function valueResourceIsAllowed($role, Value $resource, $privilege)
    {
        switch ($privilege) {
            case 'delete':
                //TODO kontrola, jestli jsou v kategorii nějaké produkty - pokud ano, nesmažeme ji
        }

        return parent::isAllowed($role, 'Attribute', $privilege);
    }
}
