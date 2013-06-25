<?php

namespace InoOicClientTest\Client\Authenticator;

use InoOicClient\Client\Authenticator\SecretBasic;


class SecretBasicTest extends \PHPUnit_Framework_Testcase
{


    public function testSetAuth()
    {
        $clientId = '123';
        $secret = 'abc';
        
        $authString = 'base64 string';
        
        $authenticator = $this->getMockBuilder('InoOicClient\Client\Authenticator\SecretBasic')
            ->setMethods(array(
            'encode'
        ))
            ->getMock();
        $authenticator->expects($this->once())
            ->method('encode')
            ->with($clientId, $secret)
            ->will($this->returnValue($authString));
        
        $headers = $this->getMock('Zend\Http\Headers');
        $headers->expects($this->once())
            ->method('addHeaderLine')
            ->with('Authorization', $authString);
        
        $httpRequest = $this->getMock('Zend\Http\Request');
        $httpRequest->expects($this->once())
            ->method('getHeaders')
            ->will($this->returnValue($headers));
        
        $authenticator->setAuth($httpRequest, $clientId, $secret);
    }


    public function testEncode()
    {
        $clientId = '123';
        $secret = 'abc';
        
        $authString = base64_encode($clientId . ':' . $secret);
        
        $authenticator = new SecretBasic();
        $this->assertSame($authString, $authenticator->encode($clientId, $secret));
    }
}