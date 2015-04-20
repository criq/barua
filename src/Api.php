<?php

namespace Brief;

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
		$request = new Request($this);

		// XmlRequest as the only argument.
		if (count(func_get_args()) == 1 && func_get_arg(0) instanceof XmlRequest) {
			$request->setXmlRequest(func_get_arg(0));
		}

		// Endpoint as only arguments.
		if (count(func_get_args()) == 2) {
			$request->setEndpoint(func_get_arg(0), func_get_arg(1));
		}

		// Endpoint and XmlRequest as only arguments.
		if (count(func_get_args()) == 3 && func_get_arg(2) instanceof XmlRequest) {
			$request->setXmlRequest(func_get_arg(2));
			$request->setEndpoint(func_get_arg(0), func_get_arg(1));
		}

		return $request;
	}

	public function createXmlRequest() {
		return new XmlRequest($this);
	}

	// User.

	public function usersTestCredentials() {
		return $this->createRequest('Users', 'testCredentials')
			->getResponse()
			->getString()
			->getBoolean()
			;
	}

	public function usersGetId() {
		return $this->createRequest('Users', 'getId')
			->getResponse()
			->getString()
			->getInt()
			;
	}

	// Contacts.

	public function contactsCreateUpdate($xmlRequest) {
		return $this->createRequest('Contacts', 'createupdate', $xmlRequest)
			->getResponse()
			->getString()
			->getBoolean()
			;
	}

	public function contactsCreateUpdateBatch($xmlRequest) {
		return $this->createRequest('Contacts', 'createupdateBatch', $xmlRequest)
			->getResponse()
			->getString()
			->getBoolean()
			;
	}

	// Contact lists.

	public function contactListsGetAll() {
		return $this->createRequest('ContactLists', 'getAll')
			->getResponse()
			->getList()
			->getModels('ContactList')
			;
	}

	public function contactListsCreate($name, $trackedDefaultFields, $sendername, $senderemail, $replyto, $publicname) {
		return $this->createRequest('ContactLists', 'create')
			->setDetails([
				'name' => $name,
				'trackedDefaultFields' => serialize($trackedDefaultFields),
				'sendername' => $sendername,
				'senderemail' => $senderemail,
				'replyto' => $replyto,
				'publicname' => $publicname,
			])
			->getResponse()
			->getModel('ContactList')
			;
	}

	// Campaigns.

	public function campaignsGetAll() {
		return $this->createRequest('Campaigns', 'getAll')
			->getResponse()
			->getList()
			->getModels('Campaign')
			;
	}

	public function campaignsCreate($name, $title, $htmlbody, $textbody) {
		return $this->createRequest('Campaigns', 'create')
			->setDetails([
				'name' => $name,
				'title' => $title,
				'htmlbody' => $htmlbody,
				'textbody' => $textbody,
			])
			->getResponse()
			->getString()
			->getInt()
			;
	}

	// Custom fields.

	public function customFieldsGetAll() {
		return $this->createRequest('CustomFields', 'getAll')
			->getResponse()
			->getList()
			->getModels('CustomField')
			;
	}

}
