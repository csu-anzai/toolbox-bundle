<?php

namespace Atournayre\ToolboxBundle\Service\Email;

use Swift_Mailer;
use Swift_Message;
use Swift_Mime_SimpleMimeEntity;

class SwiftMailerService implements EmailInterface
{
    /**
     * @var Swift_Mailer
     */
    private $mailerService;

    /**
     * SwiftMailerService constructor.
     *
     * @param Swift_Mailer $mailerService
     */
    public function __construct(Swift_Mailer $mailerService)
    {
        $this->mailerService = $mailerService;
    }

    /**
     * @param string $subject
     * @param string $from
     * @param string $body
     *
     * @return Swift_Message
     */
    public function create(string $subject, string $from, string $body)
    {
        return (new Swift_Message($subject))
            ->setFrom($from)
            ->setBody($body);
    }

    /**
     * @param Swift_Message $message
     * @param array         $addresses
     * @param string|null   $name
     *
     * @return Swift_Message
     */
    public function setTo($message, array $addresses, ?string $name = null)
    {
        $message->setTo($addresses, $name);
        return $message;
    }

    /**
     * @param Swift_Message $message
     * @param array         $addresses
     * @param string|null   $name
     *
     * @return Swift_Message
     */
    public function setCc($message, array $addresses, ?string $name = null)
    {
        $message->setCc($addresses, $name);
        return $message;
    }

    /**
     * @param Swift_Message $message
     * @param array         $addresses
     * @param string|null   $name
     *
     * @return Swift_Message
     */
    public function setBcc($message, array $addresses, ?string $name = null)
    {
        $message->setBcc($addresses, $name);
        return $message;
    }

    /**
     * @param Swift_Message $message
     * @param array         $addresses
     * @param string|null   $name
     *
     * @return Swift_Message
     */
    public function setReplyTo($message, array $addresses, ?string $name = null)
    {
        $message->setReplyTo($addresses, $name);
        return $message;
    }

    /**
     * @param Swift_Message               $message
     * @param Swift_Mime_SimpleMimeEntity $simpleMimeEntity
     *
     * @return Swift_Message
     */
    public function attach($message, $simpleMimeEntity)
    {
        $message->attach($simpleMimeEntity);
        return $message;
    }

    /**
     * @param Swift_Message $message
     *
     * @return int
     */
    public function send($message): int
    {
        return $this->mailerService->send($message);
    }
}
