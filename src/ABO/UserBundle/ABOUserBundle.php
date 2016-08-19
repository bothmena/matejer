<?php

namespace ABO\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ABOUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
