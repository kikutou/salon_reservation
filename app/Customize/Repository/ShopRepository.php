<?php

/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) EC-CUBE CO.,LTD. All Rights Reserved.
 *
 * http://www.ec-cube.co.jp/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Customize\Repository;

use Customize\Entity\Shop;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * BaseInfoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ShopRepository extends \Eccube\Repository\AbstractRepository
{
    /**
     * BaseInfoRepository constructor.
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Shop::class);
    }


	public function getQueryBuilderBySearchData($searchData)
	{
		$qb = $this->createQueryBuilder('c')
			->select('c');


		return $qb;
	}


}
