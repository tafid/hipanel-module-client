<?php

namespace hipanel\modules\client\tests\acceptance\admin\client\profile\usermenu;

use hipanel\tests\_support\Step\Acceptance\Admin;
use hipanel\helpers\Url;

class ChangePasswordCest
{
    /**
     * @var string
     */
    private $warningSelector = '';

    /**
     * @var array
     */
    private $labels = [];

    public function __construct()
    {
        $this->warningSelector = '//label[@class="control-label"]/../p';
        $this->labels = [
            ['text' => 'Login',            'warning' => ''],
            ['text' => 'Current password', 'warning' => 'cannot be blank.'],
            ['text' => 'New password',     'warning' => 'cannot be blank.'],
            ['text' => 'Confirm password', 'warning' => 'cannot be blank.'],
        ];
    }

    public function ensureThatChangePasswordWorks(Admin $I)
    {
        $I->login();
        $I->needPage(Url::to(['@client/view', 'id' => $I->id]));
        $I->click('Change password');
        $I->waitForElement('#change-password-form');

        $this->testVisibility($I);
        $this->testWarnings($I);
        $this->testShowPasswordButton($I);
        $this->testDropDownMenu($I);

        $I->click('Cancel');
        $I->seeCurrentUrlEquals(Url::to(['@client/view', 'id' => $I->id]));
    }

    private function testVisibility(Admin $I)
    {
        $labelSelector = '//label[@class="control-label"]';

        foreach ($this->labels as $label) {
            $I->see($label['text'], $labelSelector);
        }
    }

    private function testWarnings(Admin $I)
    {
        $I->click('Save');
        $I->waitForText('cannot be blank.');

        foreach ($this->labels as $label) {
            if ($label['warning'] !== '') {
                $I->see("{$label['text']} {$label['warning']}", $this->warningSelector);
            }
        }

        $oldPassword = '0';
        $newPassword = 'NVc27ruX';

        $I->fillField(['name' => "Client[{$I->id}][old_password]"], $oldPassword);
        $I->fillField(['name' => "Client[{$I->id}][new_password]"], $newPassword);
        $I->fillField(['name' => "Client[{$I->id}][confirm_password]"], $oldPassword);
        $I->click('Save');
        $I->waitForText('incorrect');
        $I->see('The password is incorrect', $this->warningSelector);
        $I->see('Confirm password must be equal to "New password".', $this->warningSelector);
    }

    private function testShowPasswordButton(Admin $I)
    {
        $I->click(['css' => '.show-password']);
        $I->waitForElement('//span[contains(@class, "glyphicon-eye-close")]');
        $I->click(['css' => '.show-password']);
        $I->waitForElement('//span[contains(@class, "glyphicon-eye-open")]');
    }

    private function testDropDownMenu(Admin $I)
    {
        $I->click('Random');
        $I->waitForElement('//button[@aria-expanded="true"]');
        $I->see('Weak', '//ul[@class="dropdown-menu"]/li/a[@class="random-passgen"]');
        $I->see('Medium', '//ul[@class="dropdown-menu"]/li/a[@class="random-passgen"]');
        $I->see('Strong', '//ul[@class="dropdown-menu"]/li/a[@class="random-passgen"]');
    }
}