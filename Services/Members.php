<?php
/**
 * Created by PhpStorm.
 * User: carl
 * Date: 01/06/17
 * Time: 15:49
 */

namespace PartFire\MailChimpBundle\Services;

use PartFire\MailChimpBundle\Model\Dto\Member;

class Members
{
    private $apiKey;
    private $listId;

    public function __construct($apiKey, $listId)
    {
        $this->apiKey = $apiKey;
        $this->listId = $listId;
    }

    public function addUserToList(Member $member)
    {
        $data = array(
            'apikey'        => $this->apiKey,
            'email_address' => $member->getEmail(),
            'status'        => $member->getStatus(),
            'merge_fields'  => array(
                'FNAME' => $member->getFirstName(),
                'LNAME' => $member->getLastName()
            )
        );

        $result = $this->executeRequest($data);
        return $result;
    }

    public function getBaseRequestUrl()
    {
        $parts = explode('-', $this->apiKey);
        $dataCenter = array_pop($parts);
        return "https://$dataCenter.api.mailchimp.com/3.0";
    }

    private function executeRequest($data)
    {
        $auth = base64_encode('user:'.$this->apiKey);
        $json_data = json_encode($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->getBaseRequestUrl() . '/lists/' . $this->listId . '/members/');

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
            'Authorization: Basic ' . $auth));
        curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        try {
            $result = curl_exec($ch);
        } catch (\Exception $exception) {
            return $exception;
        }
        return $result;
    }
}
