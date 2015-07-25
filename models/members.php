
<?php
class Members{
    private $memberid;
    private $facebookidmember;
    private $name;
    private $administrator;
    private $groupid;
    
    function getMemberid() {
        return $this->memberid;
    }

    function getFacebookidmember() {
        return $this->facebookidmember;
    }

    function getName() {
        return $this->name;
    }

    function getAdministrator() {
        return $this->administrator;
    }

    function getGroupid() {
        return $this->groupid;
    }

    function setMemberid($memberid) {
        $this->memberid = $memberid;
    }

    function setFacebookidmember($facebookidmember) {
        $this->facebookidmember = $facebookidmember;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setAdministrator($administrator) {
        $this->administrator = $administrator;
    }

    function setGroupid($groupid) {
        $this->groupid = $groupid;
    }
    
    function __construct() {
        
    }
}

?>
