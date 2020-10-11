<?php

namespace Customize\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class ShopController
{
	/**
	 * @Method("GET")
	 * @Route("/shop/entry")
	 */
	public function testMethod()
	{
		return new Response('Hello this is shop entry page');
	}
}