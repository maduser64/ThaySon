<?php
require __DIR__.'/host.php';
require_once $ROOT.'/dao/daoUsers.php';
require_once $ROOT.'/models/users.php';




class EmailLookup {
    private $emails = array();
        private function init(){
            $userList = getListUsers();
            $userItem = new Users();
            $emailsList = array();
          //  $emailItem = array()
            foreach ($userList as $userItem){
                $emailItem = array($userItem->getFullName(),$userItem->getUserName(),$userItem->getUserId());
                array_push($emailsList, $emailItem);
            }
            $this->emails =   $emailsList;
        }

	private function contains($array_unit, $term) {
		if (stripos($array_unit[0], $term) !== false)
			return true;
		if (stripos($array_unit[1], $term) !== false)
			return true;
		if (stripos($array_unit[2], $term) !== false)
			return true;
		return false;
	}   

	private function queryEmails($search_term) {
		$email_addresses = array();
                $this->init();
		foreach ($this->emails AS $email) {
			$email_address = array();
			if ($this->contains($email, $search_term)) {
				$email_address['first_name'] = $email[0];
				$email_address['last_name'] = $email[1];
				$email_address['displayname'] = $email[0];
			
				$email_address['name'] = $email[2];
//had to use name, since i couldn't format my results with 'email'
//seems it only has support for name and id
				$email_addresses[] = $email_address;
			}
		}   
		print json_encode($email_addresses);
	}


	function __construct($search_term) {
		//do i need to inti this list?
		//$email_list = new emailList();
//            echo("<script>console.log('PHP:');</script>");
		$this->queryEmails($search_term);
	}

}

$email_lookup = new EmailLookup($_REQUEST['q']);
//$email_lookup = new EmailLookup("3");
?>
