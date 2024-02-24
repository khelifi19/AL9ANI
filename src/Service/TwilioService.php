<?php

namespace App\Service;

use Twilio\Rest\Client;

class TwilioService
{


    public function sendSMS(string $number, string $text)
    {
       
        $accountSid = $_ENV['TWILIO_ACCOUNT_SID'];  //Identifiant du compte twilio
        $authToken = $_ENV['TWILIO_AUTH_TOKEN']; //Token d'authentification
        $fromNumber = $_ENV['TWILIO_PHONE_NUMBER']; // Numéro de test d'envoie sms offert par twilio

        $toNumber = $number; // Le numéro de la personne qui reçoit le message
        $message = 'Al9ANi vous a envoyé le message suivant:'.' '.$text.''; //Contruction du sms                   
                
        $client = new Client($accountSid, $authToken);

        $client->messages->create(
            $toNumber,
            [
                'from' => $fromNumber,
                'body' => $message,
            ]
        );
                
              
    }
}