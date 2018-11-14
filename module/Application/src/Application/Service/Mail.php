<?php
namespace Application\Service;

use Zend\Mail as ZendMail;
use Test\Data;
use Zend\Mail\Transport\Smtp;
use Zend\Mail\Transport\SmtpOptions;

class Mail {
    public static function mail($to, $subject, $message) {
        $mail = new ZendMail\Message();
        $mail->setBody($message);
        $mail->addTo($to);
        $mail->setSubject($subject);
        
        $transport = new ZendMail\Transport\Sendmail();
        $transport->send($mail);
    }
    
    public static function mailSmtp($to, $subject, $message) {
        $mail = new ZendMail\Message();
        $mail->setBody($message);
        $mail->addTo($to);
        $mail->setSubject($subject);
        
        $data = Data::getInstance();
        $config = $data->get('config');
        $smtpConfig = $config['emailSmtp'];
        
        $mail->setFrom($smtpConfig['options']['connection_config']['username']);
        
        $options   = new SmtpOptions($smtpConfig['options']);
        $transport = new Smtp();
        $transport->setOptions($options);
        $transport->send($mail);
    }
    
}