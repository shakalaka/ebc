<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
 */
class Task
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $input;

    /**
     * @ORM\Column(type="integer")
     */
    private $output;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $user_id;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getInput(): ?string
    {
        return $this->input;
    }

    /**
     * @param string $input
     * @return Task
     */
    public function setInput(string $input): self
    {
        $this->input = $input;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getOutput(): ?int
    {
        return $this->output;
    }

    /**
     * @param int $output
     * @return Task
     */
    public function setOutput(int $output): self
    {
        $this->output = $output;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    /**
     * @param int|null $user_id
     * @return Task
     */
    public function setUserId(?int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }
}
