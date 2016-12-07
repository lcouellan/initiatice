<?php

namespace initiatice\AdminBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class initiaticeAdminBundle extends Bundle
{
	public function getParent()
    {
        return 'FOSUserBundle';
    }
}
