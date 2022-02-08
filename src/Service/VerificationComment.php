<?php

namespace App\Service;

use App\Entity\Comment;


class VerificationComment
{
    public function commentNonAutoriser(Comment $comment): bool
    {
        $nonAutoriser =  array( "mauvais",
            "merde",
            "pourri");

        for($i = 0 ; $i < count($nonAutoriser) ; $i++ ){
            if($comment->getContenu() == $nonAutoriser[$i]){
                return true;
            }
        }

        return false;

    }
}