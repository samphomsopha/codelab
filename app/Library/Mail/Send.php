<?php
namespace App\Library\Mail;
use Mailgun\Mailgun;

class Send {
    private $api_key = 'key-b01191a070ebcf5719eef9383fc1dfdc';

    public function sendInviteEmail($to_emails, $from_user, $code, $goupname) {
        $mg = new Mailgun($this->api_key);
        $domain = "collabii.com";
        $rt = array();
        foreach($to_emails as $email)
        {
            # Now, compose and send your message.
            $rt[] = $mg->sendMessage($domain, array('from'    => 'collabii@collabii.com',
                'to'      => $to_emails,
                'subject' => 'Collabii Invite From '.$from_user->get('name'),
                'html'    => '<img src="http://www.collabii.com/img/logo.png" alt="Collabii"/><p>Hi, '.$from_user->get('name').' has invited you to join a Collabii group.  Just click on the invite link below.</p>
                                <a href="http://www.collabii.com/joingroup/email/'.$code.'">'.$goupname.'</a>'
            ));
        }
        return $rt;
    }
}