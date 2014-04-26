<?php
namespace PaysonAPI;

/*
 * Container class for credentials used to log in via Payson API.
 */

class PaysonCredentials 
{
    const USERID         = 'PAYSON-SECURITY-USERID:';
    const PASSWORD       = 'PAYSON-SECURITY-PASSWORD:'; 
    const APPLICATION_ID = 'PAYSON-APPLICATION-ID:'; 
    const MODULE_INFO    = 'PAYSON-MODULE-INFO:';

    protected $userId;
    protected $password;
    protected $applicationId;
    protected $moduleInfo;

    /**
     * Sets up a PaysonCredential object
     * @param  string $userId API user id 
     * @param  string $password API password
     * @param null $applicationId
     * @param string $moduleInfo version of library
     */
    public function __construct($userId, $password, $applicationId, $moduleInfo = 'github.com/johanhenriksson/PaysonAPI|1.0')
    {
        $this->userId = $userId;
        $this->password = $password;
        $this->applicationId = $applicationId;
        $this->moduleInfo = $moduleInfo;
    }

    public function UserId() {
        return $this->userId;
    }

    public function Password() {
        return $this->password;
    }

    public function ApplicationId() {
        return $this->applicationId;
    }

    public function ModuleInfo() {
        return $this->moduleInfo;
    }

    public function toHeader() 
    {
        return array(
            self::USERID         . $this->UserId(),
            self::PASSWORD       . $this->Password(),
            self::APPLICATION_ID . $this->ApplicationId(),
            self::MODULE_INFO    . $this->ModuleInfo()
        );
    }
}
?>
