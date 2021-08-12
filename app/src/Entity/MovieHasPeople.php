<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Movie
 *
 * @ORM\Table(name="movie_has_people")
 * @ORM\Entity(repositoryClass="App\Repository\MovieHasPeopleRepository")
 */
class MovieHasPeople
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="App\Entity\Movie")
     * @ORM\JoinColumn(name="movie_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private Movie $movie;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="App\Entity\People")
     * @ORM\JoinColumn(name="people_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private People $people;

    /**
     * @ORM\Column(name="role", type="string", length=255, nullable=false)
     */
    private string $role;

    /**
     * @ORM\Column(name="significance", type="significance", nullable=true)
     */
    private ?string $significance;

    public function getMovie(): Movie
    {
        return $this->movie;
    }

    public function setMovie(Movie $movie): self
    {
        $this->movie = $movie;

        return $this;
    }

    public function getPeople(): People
    {
        return $this->people;
    }

    public function setPeople(People $people): self
    {
        $this->people = $people;

        return $this;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getSignificance(): ?string
    {
        return $this->significance;
    }

    public function setSignificance(?string $significance): self
    {
        $this->significance = $significance;

        return $this;
    }
}
