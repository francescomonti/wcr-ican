<?php

namespace Wcr\Ican;

use Illuminate\Database\Eloquent\Model;
use Wcr\Ican\UserRole;
use Wcr\Ican\EntityRelation;

class Permission extends Model
{
    public function to_str(){
        return $this->entity_type.'::'.$this->action.'::'.$this->rel;
    }

    public static function findByUser($user_id){
        $permissions = array();

        $userPermissions = Permission::where('user_id', '=', $user_id)->get();
        foreach($userPermissions as $p){
            $permissions[] = $p->to_str();
        }

        $userRoles = UserRole::where('user_id', '=', $user_id)->get();

        foreach ($userRoles as $userRole){
            foreach (Permission::where('role_id', '=', $userRole->role_id)->get() as $p){
                $permissions[] = $p->to_str();
            }
        }

        return $permissions;
    }

    public static function requiredByUser($action, $entity, $user_id){
        $rel = EntityRelation::withUser($entity, $user_id);
        if ($rel == 'none') $rel = 'all';
        return get_class($entity).'::'.$action.'::'.$rel;
    }

    public static function userHasPermission($action, $entity, $user_id){
        $userPermissions = Permission::findByUser($user_id);
        $requiredPermission = Permission::requiredByUser($action, $entity, $user_id);
        if( in_array($requiredPermission, $userPermissions) ) return true;
        else return false;
    }
}