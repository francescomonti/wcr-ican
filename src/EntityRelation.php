<?php

namespace Wcr\Ican;

use Wcr\Owner\Owner;

class EntityRelation
{
    public static function withUser ($entity, $user_id){
        if(Owner::where('user_id', '=', $user_id)
            ->where('entity_id', '=', $entity->id)
            ->where('entity_type', '=', get_class($entity))
            ->count()>0) return 'own';
        else return 'none';
    }
}