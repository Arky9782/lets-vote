<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ElectionRepository")
 */
class Election
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
     * @ORM\Column(type="string", length=255)
     */
    private $hash;

    /**
     * @ORM\OneToMany(targetEntity="Choice", mappedBy="election")
     */
    private $choices;

    public function __construct()
    {
        $this->choices = new ArrayCollection();
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

    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function setHash(string $hash): self
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getChoices(): ArrayCollection
    {
        return $this->choices;
    }

    /**
     * @param Choice $choice
     */
    public function addChoice(Choice $choice): void
    {
        $this->choices->add($choice);
        $choice->setElection($this);
    }

    public function vote(Choice $choice)
    {
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq('id', $choice->getId()))
            ->getFirstResult();

        $choiceToVoteFor = $this->choices->matching($criteria);

        $currentAmountOfVotes = $choiceToVoteFor->getVotes();
        $votesToAdd = $choice->getVotes();
        $choiceToVoteFor->setVotes($currentAmountOfVotes + $votesToAdd);
    }
}
