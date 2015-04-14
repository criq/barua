<?php

namespace Barua;

class Api {

	public $username;
	public $usertoken;
	public $url = 'https://app.smartemailing.cz/api/v2';

	public function __construct($username, $usertoken, $url = null) {
		$this->username = $username;
		$this->usertoken = $usertoken;
		if ($url) {
			$this->url = $url;
		}
	}

	public function createRequest() {
		return new Request($this);
	}

	// User.

	public function usersTestCredentials() {
		return (string) $this->createRequest()->setEndpoint('Users', 'testCredentials')->getResponse()->getString();
	}

	public function usersGetId() {
		return (int) (string) $this->createRequest()->setEndpoint('Users', 'getId')->getResponse()->getString();
	}

	// Contact lists.

	public function contactListsGetAll() {
		return $this->createRequest()->setEndpoint('ContactLists', 'getAll')->getResponse()->getList()->getAsModels('ContactList');
	}

	public function contactListsCreate($name, $trackedDefaultFields, $sendername, $senderemail, $replyto, $publicname) {
		$request = $this->createRequest()
			->setEndpoint('ContactLists', 'create')
			->setDetails([
				'name' => $name,
				'trackedDefaultFields' => serialize($trackedDefaultFields),
				'sendername' => $sendername,
				'senderemail' => $senderemail,
				'replyto' => $replyto,
				'publicname' => $publicname,
			])
			;

		return (int) (string) $request->getResponse()->getString();
	}

	// Campaigns.

	public function campaignsGetAll() {
		return $this->createRequest()->setEndpoint('Campaigns', 'getAll')->getResponse()->getList()->getAsModels('Campaign');
	}

	public function campaignsCreate($name, $title, $html, $text) {
		$request = $this->createRequest()
			->setEndpoint('Campaigns', 'create')
			->setDetails([
				'name' => $name,
				'title' => $title,
				'htmlbody' => $html,
				'textbody' => $text,
			])
			;

		return (int) (string) $request->getResponse()->getString();
	}

}
