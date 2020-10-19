<?php
/**
 * Created by PhpStorm.
 * User: juteng
 * Date: 2020/10/19
 * Time: 8:16
 */

namespace Customize\Service;


use Customize\Entity\Shop;
use Eccube\Service\MailService;

class ShopMailService extends MailService
{

	public function sendShopConfirmMail(Shop $shop)
	{

		$MailTemplate = $this->mailTemplateRepository->find($this->eccubeConfig['eccube_shop_entry_confirm_mail_template_id']);

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


	public function sendShopConfirmMailToAdmin(Shop $shop, $activateUrl)
	{

		$MailTemplate = $this->mailTemplateRepository->find($this->eccubeConfig['eccube_shop_entry_confirm_to_admin_mail_template_id']);

		$body = $this->twig->render($MailTemplate->getFileName(), [
			'Shop' => $shop,
			'BaseInfo' => $this->BaseInfo,
			"activateUrl" => $activateUrl
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
				"activateUrl" => $activateUrl
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


	public function sendShopEntryCompleteMail(Shop $shop, $loginUrl)
	{

		$MailTemplate = $this->mailTemplateRepository->find($this->eccubeConfig['eccube_shop_entry_complete_mail_template_id']);

		$body = $this->twig->render($MailTemplate->getFileName(), [
			'Shop' => $shop,
			'BaseInfo' => $this->BaseInfo,
			"loginUrl" => $loginUrl
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
				"loginUrl" => $loginUrl
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