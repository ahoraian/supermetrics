<?php declare(strict_types=1);

namespace App\Entities;

use DateTime;

class Post
{
    /**
     * @var string
     */
    private string $id;

    /**
     * @var string
     */
    private string $from_name;

    /**
     * @var string
     */
    private string $from_id;

    /**
     * @var string
     */
    private string $message;

    /**
     * @var string
     */
    private string $type;

    /**
     * @var DateTime
     */
    private DateTime $created_time;

    /**
     * Post constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        // set object properties by incoming data
        foreach($data as $key => $val) {
            $this->{$key} = $val;
        }
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getFromName(): string
    {
        return $this->from_name;
    }

    /**
     * @param string $from_name
     */
    public function setFromName(string $from_name): void
    {
        $this->from_name = $from_name;
    }

    /**
     * @return string
     */
    public function getFromId(): string
    {
        return $this->from_id;
    }

    /**
     * @param string $from_id
     */
    public function setFromId(string $from_id): void
    {
        $this->from_id = $from_id;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return DateTime
     */
    public function getCreatedTime(): DateTime
    {
        return $this->created_time;
    }

    /**
     * @param DateTime $created_time
     */
    public function setCreatedTime(DateTime $created_time): void
    {
        $this->created_time = $created_time;
    }
}