<?php

namespace Atournayre\ToolboxBundle\Service\Email;

interface EmailInterface
{
    /**
     * @param string $subject
     * @param string $from
     * @param string $body
     *
     * @return mixed
     */
    public function create(string $subject, string $from, string $body);

    /**
     * @param mixed       $message
     * @param array       $addresses
     * @param string|null $name
     *
     * @return mixed
     */
    public function setTo($message, array $addresses, ?string $name = null);

    /**
     * @param mixed       $message
     * @param array       $addresses
     * @param string|null $name
     *
     * @return mixed
     */
    public function setCc($message, array $addresses, ?string $name = null);

    /**
     * @param mixed       $message
     * @param array       $addresses
     * @param string|null $name
     *
     * @return mixed
     */
    public function setBcc($message, array $addresses, ?string $name = null);

    /**
     * @param mixed       $message
     * @param array       $addresses
     * @param string|null $name
     *
     * @return mixed
     */
    public function setReplyTo($message, array $addresses, ?string $name = null);

    /**
     * @param mixed $message
     * @param mixed $simpleMimeEntity
     *
     * @return mixed
     */
    public function attach($message, $simpleMimeEntity);

    /**
     * @param mixed $message
     *
     * @return int
     */
    public function send($message): int;
}
