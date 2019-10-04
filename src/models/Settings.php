<?php
namespace verbb\knockknock\models;

use verbb\knockknock\KnockKnock;

use Craft;
use craft\base\Model;

class Settings extends Model
{
    // Public Properties
    // =========================================================================
    
    public $enabled = false;
    public $password;
    public $loginPath;
    public $template;
    public $siteSettings = [];

    public $checkInvalidLogins = false;
    public $invalidLoginWindowDuration = '3600';
    public $maxInvalidLogins = 10;
    public $whitelistIps;
    public $blacklistIps;


    // Public Methods
    // =========================================================================

    public function getEnabled()
    {
        return $this->_getSettingValue('enabled') ?? false;
    }

    public function getTemplate()
    {
        return $this->_getSettingValue('template') ?? '';
    }

    public function getPassword()
    {
        return $this->_getSettingValue('password') ?? '';
    }

    public function getLoginPath()
    {
        return $this->_getSettingValue('loginPath') ?? 'knock-knock/who-is-there';
    }

    public function getWhitelistIps()
    {
        return explode("\n", $this->whitelistIps) ?? [];
    }

    public function getBlacklistIps()
    {
        return explode("\n", $this->blacklistIps) ?? [];
    }


    // Private Methods
    // =========================================================================

    private function _getSettingValue($value)
    {
        $currentSite = Craft::$app->getSites()->getCurrentSite();
        $siteSettings = $this->siteSettings[$currentSite->handle] ?? [];

        // Allow global override
        if ($this->$value) {
            return $this->$value;
        }

        if (Craft::$app->getIsMultiSite() && $siteSettings) {
            return $siteSettings[$value];
        }

        return null;
    }
}
