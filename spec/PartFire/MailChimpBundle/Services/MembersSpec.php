<?php

namespace spec\PartFire\MailChimpBundle\Services;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MembersSpec extends ObjectBehavior
{
    function it_should_return_a_valid_api_url()
    {
        $this->beConstructedWith('0e649896e4cdddd22f1bc84ec4c6e43c-us15');
        $this->getBaseRequestUrl()->shouldBe('https://us15.api.mailchimp.com/3.0');
    }
}
