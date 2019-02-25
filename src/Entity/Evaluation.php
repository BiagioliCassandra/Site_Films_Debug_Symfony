<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EvaluationRepository")
 */
class Evaluation
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
    private $comment;

    /**
     * @ORM\Column(type="integer")
     */
    private $grade;

    /**
     * @ORM\Column(type="date")
     */
    private $evalDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Movie", inversedBy="evaluations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $movie;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="evaluations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    const MIN_GRADE = 0;
    const MAX_GRADE = 10;

    public function __construct() {
      $this->evalDate = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getGrade(): ?int
    {
        return $this->grade;
    }

    public function setGrade(int $grade): self
    {
        if($grade >= self::MIN_GRADE && $grade <= self::MAX_GRADE) {
          $this->grade = $grade;
        }
        return $this;
    }

    public function getEvalDate(): ?\DateTimeInterface
    {
        return $this->evalDate;
    }

    public function setEvalDate(\DateTimeInterface $evalDate): self
    {
        $this->evalDate = $evalDate;

        return $this;
    }

    public function getMovie(): ?Movie
    {
        return $this->movie;
    }

    public function setMovie(?Movie $movie): self
    {
        $this->movie = $movie;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
