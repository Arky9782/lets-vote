<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ChoiceRepository")
 */
class Choice
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Type("string")
     */
    private $title;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Type("integer")
     */
    private $votes;

    /**
     * @ORM\ManyToOne(targetEntity="Election", inversedBy="choices")
     */
    private $election;

    public function __construct()
    {
        $this->votes = 0;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getVotes(): ?int
    {
        return $this->votes;
    }

    public function setVotes(int $votes): self
    {
        $this->votes = $votes;

        return $this;
    }

    /**
     * @return Election
     */
    public function getElection(): Election
    {
        return $this->election;
    }

    /**
     * @param Election $election
     */
    public function setElection(Election $election): void
    {
        $this->election = $election;
    }
}
