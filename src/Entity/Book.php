<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: BookRepository::class)]
#[ApiResource(
    description: 'Книга',
    operations: [
        new Get(normalizationContext: ['groups' => 'book:item']),
        new GetCollection(normalizationContext: ['groups' => 'book:list']),
        new Post(normalizationContext: ['groups' => 'book:write']),
        new Delete(),
    ],
    order: ['id' => 'ASC'],
    paginationEnabled: false,
)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups([
        'book:list',
        'book:item',
        'book:write',
        'author:item',
        'publisher:item',
    ])]
    private ?string $name = null;

    #[ORM\Column]
    #[Groups(['book:list', 'book:item', 'book:write'])]
    private ?int $year = null;

    #[ORM\ManyToOne(targetEntity: Publisher::class, inversedBy: 'books')]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    #[Groups(['book:list', 'book:item', 'book:write'])]
    private ?Publisher $publisher = null;

    /**
     * @var Collection<int, Author>
     */
    #[ORM\ManyToMany(targetEntity: Author::class, mappedBy: 'books')]
    #[Groups(['book:list', 'book:item'])]
    private Collection $authors;

    public function __construct()
    {
        $this->authors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): static
    {
        $this->year = $year;

        return $this;
    }

    public function getPublisher(): ?Publisher
    {
        return $this->publisher;
    }

    public function setPublisher(?Publisher $publisher): static
    {
        $this->publisher = $publisher;

        return $this;
    }

    /**
     * @return Collection<int, Author>
     */
    public function getAuthors(): Collection
    {
        return $this->authors;
    }

    public function addAuthor(Author $author): static
    {
        if (!$this->authors->contains($author)) {
            $this->authors->add($author);
            $author->addBook($this);
        }

        return $this;
    }

    #[Groups(['book:write'])]
    public function setAuthors(array $authors): static
    {
        foreach ($authors as $author) {
            $this->addAuthor($author);
        }

        return $this;
    }

    public function removeAuthor(Author $author): static
    {
        if ($this->authors->removeElement($author)) {
            $author->removeBook($this);
        }

        return $this;
    }
}
