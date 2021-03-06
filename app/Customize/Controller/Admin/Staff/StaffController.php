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

namespace Customize\Controller\Admin\Staff;

use Customize\Form\Type\Admin\SearchStaffType;
use Customize\Repository\ShopRepository;
use Customize\Repository\StaffRepository;
use Doctrine\ORM\QueryBuilder;
use Eccube\Controller\AbstractController;
use Eccube\Repository\Master\PageMaxRepository;
use Eccube\Util\FormUtil;
use Knp\Component\Pager\Paginator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class StaffController extends AbstractController
{
    /**
     * @var PageMaxRepository
     */
    protected $pageMaxRepository;

    protected $staffRepository;

    protected $shopRepository;

    public function __construct(
        PageMaxRepository $pageMaxRepository,
		StaffRepository $staffRepository,
		ShopRepository $shopRepository
    ) {
        $this->pageMaxRepository = $pageMaxRepository;
        $this->staffRepository = $staffRepository;
        $this->shopRepository = $shopRepository;
    }

    /**
     * @Route("/%eccube_admin_route%/staff", name="admin_staff")
     * @Route("/%eccube_admin_route%/staff/page/{page_no}", requirements={"page_no" = "\d+"}, name="admin_staff_page")
     * @Template("@admin/Staff/index.twig")
     */
    public function index(Request $request, $page_no = null, Paginator $paginator)
    {
        $session = $this->session;

        $builder = $this->formFactory->createBuilder(SearchStaffType::class);
        $searchForm = $builder->getForm();

        $pageMaxis = $this->pageMaxRepository->findAll();

        $pageCount = $session->get('eccube.admin.staff.search.page_count', $this->eccubeConfig['eccube_default_page_count']);
        $pageCountParam = $request->get('page_count');
        if ($pageCountParam && is_numeric($pageCountParam)) {
            foreach ($pageMaxis as $pageMax) {
                if ($pageCountParam == $pageMax->getName()) {
                    $pageCount = $pageMax->getName();
                    $session->set('eccube.admin.staff.search.page_count', $pageCount);
                    break;
                }
            }
        }

        if ('POST' === $request->getMethod()) {
            $searchForm->handleRequest($request);
            if ($searchForm->isValid()) {
                $searchData = $searchForm->getData();
                $page_no = 1;

                $session->set('eccube.admin.staff.search', FormUtil::getViewData($searchForm));
                $session->set('eccube.admin.staff.search.page_no', $page_no);
            } else {
                return [
                    'searchForm' => $searchForm->createView(),
                    'pagination' => [],
                    'pageMaxis' => $pageMaxis,
                    'page_no' => $page_no,
                    'page_count' => $pageCount,
                    'has_errors' => true,
                ];
            }
        } else {
            if (null !== $page_no || $request->get('resume')) {
                if ($page_no) {
                    $session->set('eccube.admin.staff.search.page_no', (int) $page_no);
                } else {
                    $page_no = $session->get('eccube.admin.staff.search.page_no', 1);
                }
                $viewData = $session->get('eccube.admin.staff.search', []);
            } else {
                $page_no = 1;
                $viewData = FormUtil::getViewData($searchForm);
                $session->set('eccube.admin.staff.search', $viewData);
                $session->set('eccube.admin.staff.search.page_no', $page_no);
            }
            $searchData = FormUtil::submitAndGetData($searchForm, $viewData);
        }

        /** @var QueryBuilder $qb */
        $qb = $this->staffRepository->getQueryBuilderBySearchData($searchData);

	    if(($this->getUser()->getAuthority()->getId() == 2)) {
	    	$Shop = $this->shopRepository->findOneBy(["memberId" => $this->getUser()->getId()]);
		    $qb->andWhere("s.shopId = :shop_id")->setParameter("shop_id", $Shop->getId());
	    }


        $pagination = $paginator->paginate(
            $qb,
            $page_no,
            $pageCount
        );

        return [
            'searchForm' => $searchForm->createView(),
            'pagination' => $pagination,
            'pageMaxis' => $pageMaxis,
            'page_no' => $page_no,
            'page_count' => $pageCount,
            'has_errors' => false,
        ];
    }


}
