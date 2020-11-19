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

namespace Customize\Command;

use Symfony\Component\Console\Command\Command;
use Customize\Repository\ShopRepository;
use Customize\Service\MailService;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SendMailCommand extends Command
{
    protected static $defaultName = 'customize:sendmail';

    protected $shopRepository;
    protected $mailService;

    public function __construct(
        ShopRepository $shopRepository,
        MailService $mailService)
    {
        parent::__construct();
        $this->shopRepository = $shopRepository;
        $this->mailService = $mailService;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $shops = $this->shopRepository->findAll();

        foreach ($shops as $shop) {
            $expiredDate = $shop->getExpireDate()->modify('+1 months')->format('Y/m/d');
            if ($expiredDate == date('Y/m/d')) {
                $this->mailService->sendExpireDateMail($shop);
            }
        }
        
        // cmd : 0 2 * * * php bin/console customize:sendmail
        $io->success('send mail successful.');
    }
}
