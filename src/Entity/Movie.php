<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MovieRepository")
 */
class Movie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $sumary;

    /**
     * @ORM\Column(type="date")
     */
    private $releaseYear;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $author;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Evaluation", mappedBy="movie")
     * @ORM\JoinColumn(nullable=false)
     */
    private $evaluations;

    public function __construct()
    {
        $this->evaluations = new ArrayCollection();
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

    public function getSumary(): ?string
    {
        return $this->sumary;
    }

    public function setSumary(string $sumary): self
    {
        $this->sumary = $sumary;

        return $this;
    }

    public function getReleaseYear(): ?\DateTimeInterface
    {
        return $this->releaseYear;
    }

    public function setReleaseYear(\DateTimeInterface $releaseYear): self
    {
        $this->releaseYear = $releaseYear;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection|Evaluation[]
     */
    public function getEvaluations(): Collection
    {
        return $this->evaluations;
    }

    public function addEvaluation(Evaluation $evaluation): self
    {
        if (!$this->evaluations->contains($evaluation)) {
            $this->evaluations[] = $evaluation;
            $evaluation->setMovie($this);
        }

        return $this;
    }

    public function removeEvaluation(Evaluation $evaluation): self
    {
        if ($this->evaluations->contains($evaluation)) {
            $this->evaluations->removeElement($evaluation);
            // set the owning side to null (unless already changed)
            if ($evaluation->getMovie() === $this) {
                $evaluation->setMovie(null);
            }
        }

        return $this;
    }

    public function getAverage() {
            //     $ms = $this->getDoctrine()->getRepository(Movie::class)->findAll();
    //     //fonction qui essé de calc moyen note flm mais prblm
    //     for ($i=0; $i < count($ms) ; $i) {
    //       $notes = $ms[$i]->getEvaluations()->getGrade();
    //     }
    //     return $this->render('test/index.html.twig', [
    //       "ms" => $ms
    //     ]);
    }
}
