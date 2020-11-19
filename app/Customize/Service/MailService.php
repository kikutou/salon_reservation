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

namespace Customize\Service;

use Eccube\Entity\BaseInfo;
use Eccube\Repository\BaseInfoRepository;
use Eccube\Repository\MailTemplateRepository;
use Customize\Entity\Shop;

class MailService
{
    /**
     * @var \Swift_Mailer
     */
    protected $mailer;

    /**
     * @var MailTemplateRepository
     */
    protected $mailTemplateRepository;

    /**
     * @var BaseInfo
     */
    protected $BaseInfo;

    /**
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * MailService constructor.
     *
     * @param \Swift_Mailer $mailer
     * @param MailTemplateRepository $mailTemplateRepository
     * @param BaseInfoRepository $baseInfoRepository
     * @param \Twig_Environment $twig
     * @param EccubeConfig $eccubeConfig
     */
    public function __construct(
        \Swift_Mailer $mailer,
        MailTemplateRepository $mailTemplateRepository,
        BaseInfoRepository $baseInfoRepository,
        \Twig_Environment $twig
    ) {
        $this->mailer = $mailer;
        $this->mailTemplateRepository = $mailTemplateRepository;
        $this->BaseInfo = $baseInfoRepository->get();
        $this->twig = $twig;
    }

    
    /**
     * [getHtmlTemplate description]
     *
     * @param  string $templateName  プレーンテキストメールのファイル名
     *
     * @return string|null  存在する場合はファイル名を返す
     */
    public function getHtmlTemplate($templateName)
    {
        // メールテンプレート名からHTMLメール用テンプレート名を生成
        $fileName = explode('.', $templateName);
        $suffix = '.html';
        $htmlFileName = $fileName[0].$suffix.'.'.$fileName[1];

        // HTMLメール用テンプレートの存在チェック
        if ($this->twig->getLoader()->exists($htmlFileName)) {
            return $htmlFileName;
        } else {
            return null;
        }
    }

    // 利用有効期限切れの通知メール
	public function sendExpireDateMail(Shop $shop)
	{
		$MailTemplate = $this->mailTemplateRepository->find(12);

		$body = $this->twig->render($MailTemplate->getFileName(), [
			'Shop' => $shop,
			'BaseInfo' => $this->BaseInfo,
		]);

		$message = (new \Swift_Message())
			->setSubject('['.$this->BaseInfo->getShopName().'] '.$MailTemplate->getMailSubject())
			->setFrom([$this->BaseInfo->getEmail01() => $this->BaseInfo->getShopName()])
			->setTo([$shop->getEmail()])
			->setBcc($this->BaseInfo->getEmail01())
			->setReplyTo($this->BaseInfo->getEmail03())
			->setReturnPath($this->BaseInfo->getEmail04());

		// HTMLテンプレートが存在する場合
		$htmlFileName = $this->getHtmlTemplate($MailTemplate->getFileName());
		if (!is_null($htmlFileName)) {
			$htmlBody = $this->twig->render($htmlFileName, [
				'Shop' => $shop,
				'BaseInfo' => $this->BaseInfo,
			]);

			$message
				->setContentType('text/plain; charset=UTF-8')
				->setBody($body, 'text/plain')
				->addPart($htmlBody, 'text/html');
		} else {
			$message->setBody($body);
		}

		$count = $this->mailer->send($message, $failures);

		return $count;
	}

}

