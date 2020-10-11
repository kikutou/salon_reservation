<?php

namespace Customize\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

class ShopController
{
	/**
	 * @Method("GET")
	 * @Route("/shop/entry")
	 * @Template("Shop/entry.twig")
	 */
	public function entry()
	{
		return [];
	}
}