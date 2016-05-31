<?php

namespace Brief;

class Api {

	public $username;
	public $usertoken;

	public $apiUrl = 'https://app.smartemailing.cz/api/v2';
	public $csvUrl = 'https://app.smartemailing.cz/api/csv';

	public function __construct($username, $usertoken) {
		$this->username = $username;
		$this->usertoken = $usertoken;
	}

	public function getCsvUrl($endpoint, $params = []) {
		return \Katu\Types\TUrl::make(implode('/', [
			$this->csvUrl,
			$endpoint,
		]), array_merge([
			'username' => $this->username,
			'usertoken' => $this->usertoken,
		], $params));
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

	public function contactsDeleteByEmailAddress($emailAddress) {
		return $this->createRequest('Contacts', 'delete')
			->setDetails([
				'emailaddress' => $emailAddress,
			])
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
			->getModels($this, 'ContactList')
			;
	}

	public function contactListsGetByName($name) {
		foreach ($this->contactListsGetAll() as $contactList) {
			if ($contactList->name == $name) {
				return $contactList;
			}
		}

		return false;
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
			->getModel($this, 'ContactList')
			;
	}

	public function contactListsMake($name, $trackedDefaultFields, $sendername, $senderemail, $replyto, $publicname) {
		foreach ($this->contactListsGetAll() as $contactList) {
			if ($contactList->name == $name) {
				return $contactList;
			}
		}

		return $this->contactListsCreate($name, $trackedDefaultFields, $sendername, $senderemail, $replyto, $publicname);
	}

	public function contactListsGetContacts($id) {
		return $this->createRequest('ContactLists', 'getContacts')
			->setDetails([
				'id' => $id,
			])
			->getResponse()
			->getList()
			->getModels($this, 'Contact')
			;
	}

	// Campaigns.

	public function campaignsGetAll() {
		return $this->createRequest('Campaigns', 'getAll')
			->getResponse()
			->getList()
			->getModels($this, 'Campaign')
			;
	}

	public function campaignsGetOne($id) {
		return $this->createRequest('Campaigns', 'getOne')
			->setDetails([
				'id' => $id,
			])
			->getResponse()
			->getModel($this, 'Campaign')
			;
	}

	public function campaignsGetByName($name) {
		foreach ($this->campaignsGetAll() as $campaign) {
			if ($campaign->name == $name) {
				return $campaign;
			}
		}

		return false;
	}

	public function campaignsCreate($name, $title, $htmlbody, $textbody) {
		return $this->createRequest('Campaigns', 'create')
			->setDetails([
				'name' => $name,
				'title' => $title,
				'htmlbody' => base64_encode($htmlbody),
				'textbody' => $textbody,
			])
			->getResponse()
			->getString()
			->getInt()
			;
	}

	public function campaignsUpdate($id, $name, $title, $htmlbody, $textbody) {
		return $this->createRequest('Campaigns', 'update')
			->setDetails([
				'id' => $id,
				'name' => $name,
				'title' => $title,
				'htmlbody' => base64_encode($htmlbody),
				'textbody' => $textbody,
			])
			->getResponse()
			->getString()
			->getInt()
			;
	}

	public function campaignsMake($name, $title, $htmlbody, $textbody) {
		foreach ($this->campaignsGetAll() as $campaign) {
			if ($campaign->name == $name) {
				$id = $campaign->id;
				$campaign->update($name, $title, $htmlbody, $textbody);
				break;
			}
		}

		if (!isset($id)) {
			$id = $this->campaignsCreate($name, $title, $htmlbody, $textbody);
		}

		return $this->campaignsGetOne($id);
	}

	// Custom fields.

	public function customFieldsGetAll() {
		return $this->createRequest('CustomFields', 'getAll')
			->getResponse()
			->getList()
			->getModels($this, 'CustomField')
			;
	}

	public function customFieldsGetOneByName($name) {
		foreach ($this->customFieldsGetAll() as $customField) {
			if ($customField->name == $name) {
				return $customField;
			}
		}

		return false;
	}

	// Autoresponders.

	public function autorespondersGetAll() {
		return $this->createRequest('Autoresponders', 'getAll')
			->getResponse()
			->getList()
			->getModels($this, 'Autoresponder')
			;
	}

	public function autorespondersGetByName($name) {
		foreach ($this->autorespondersGetAll() as $autoresponder) {
			if ($autoresponder->name == $name) {
				return $autoresponder;
			}
		}

		return false;
	}

	// Autoresponder stats.

	public function autoresponderStatsGetBounces($id) {
		return $this->createRequest('AutoresponderStats', 'getBounces')
			->setDetails([
				'id' => $id,
			])
			->getResponse()
			->getList()
			->getModels($this, 'Bounce')
			;
	}

}
