<?php

/*
 * This file is part of the BenGorUser package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\BenGorUser\MandrillBridge\Infrastructure\Mailing;

use BenGorUser\MandrillBridge\Infrastructure\Mailing\MandrillUserMailer;
use BenGorUser\User\Domain\Model\UserEmail;
use BenGorUser\User\Domain\Model\UserMailable;
use BenGorUser\User\Domain\Model\UserMailer;
use PhpSpec\ObjectBehavior;

/**
 * Spec file of MandrillUserMailer class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class MandrillUserMailerSpec extends ObjectBehavior
{
    function let(\Mandrill $mailer)
    {
        $this->beConstructedWith($mailer);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(MandrillUserMailer::class);
    }

    function it_implements_user_mailer()
    {
        $this->shouldImplement(UserMailer::class);
    }

    function it_mails(\Mandrill $mailer, \Mandrill_Messages $messages, UserMailable $mail)
    {
        $to = new UserEmail('bengor@user.com');

        $mail->to()->shouldBeCalled()->willReturn($to);
        $mail->subject()->shouldBeCalled()->willReturn('Dummy subject');
        $mail->from()->shouldBeCalled()->willReturn(new UserEmail('bengor@user.com'));
        $mail->bodyText()->shouldBeCalled()->willReturn('The email body');
        $mail->bodyHtml()->shouldBeCalled()->willReturn('<html>The email body</html>');

        $mailer->messages = $messages;

        $this->mail($mail);
    }

    function it_mails_with_multiples_receivers(\Mandrill $mailer, \Mandrill_Messages $messages, UserMailable $mail)
    {
        $to = [
            new UserEmail('bengor@user.com'),
            new UserEmail('gorka.lauzirika@gmail.com'),
            new UserEmail('benatespina@gmail.com'),
        ];

        $mail->to()->shouldBeCalled()->willReturn($to);
        $mail->subject()->shouldBeCalled()->willReturn('Dummy subject');
        $mail->from()->shouldBeCalled()->willReturn(new UserEmail('bengor@user.com'));
        $mail->bodyText()->shouldBeCalled()->willReturn('The email body');
        $mail->bodyHtml()->shouldBeCalled()->willReturn('<html>The email body</html>');

        $mailer->messages = $messages;

        $this->mail($mail);
    }
}
