<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['username'], message: 'There is already an account with this username')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $username = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'idUtente', targetEntity: Post::class, orphanRemoval: true)]
    private Collection $post;

    #[ORM\OneToOne(mappedBy: 'idUtente', cascade: ['persist', 'remove'])]
    private ?Avatar $avatar = null;

    #[ORM\OneToOne(mappedBy: 'idUtente', cascade: ['persist', 'remove'])]
    private ?BannerProfilo $bannerProfilo = null;

    #[ORM\Column(length: 50)]
    private ?string $nomeArtista = null;

    #[ORM\Column(length: 800, nullable: true)]
    private ?string $bio = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $contattoFacebook = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $contattoEmail = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $contattoInstagram = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $videoYoutube = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $idSpotify = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Album::class, orphanRemoval: true)]
    private Collection $albums;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Single::class, orphanRemoval: true)]
    private Collection $singles;

    public function __construct()
    {
        $this->post = new ArrayCollection();
        $this->albums = new ArrayCollection();
        $this->singles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string|null $username
     */
    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }


    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }


    /**
     * @return Collection<int, Post>
     */
    public function getPost(): Collection
    {
        return $this->post;
    }

    public function addPost(Post $post): self
    {
        if (!$this->post->contains($post)) {
            $this->post->add($post);
            $post->setIdUtente($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->post->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getIdUtente() === $this) {
                $post->setIdUtente(null);
            }
        }

        return $this;
    }

    public function getAvatar(): ?Avatar
    {
        return $this->avatar;
    }

    public function setAvatar(?Avatar $avatar): self
    {
        // unset the owning side of the relation if necessary
        if ($avatar === null && $this->avatar !== null) {
            $this->avatar->setIdUtente(null);
        }

        // set the owning side of the relation if necessary
        if ($avatar !== null && $avatar->getIdUtente() !== $this) {
            $avatar->setIdUtente($this);
        }

        $this->avatar = $avatar;

        return $this;
    }

    public function getBannerProfilo(): ?BannerProfilo
    {
        return $this->bannerProfilo;
    }

    public function setBannerProfilo(BannerProfilo $bannerProfilo): self
    {
        // set the owning side of the relation if necessary
        if ($bannerProfilo->getIdUtente() !== $this) {
            $bannerProfilo->setIdUtente($this);
        }

        $this->bannerProfilo = $bannerProfilo;

        return $this;
    }

    public function getNomeArtista(): ?string
    {
        return $this->nomeArtista;
    }

    public function setNomeArtista(string $nomeArtista): self
    {
        $this->nomeArtista = $nomeArtista;

        return $this;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(?string $bio): self
    {
        $this->bio = $bio;

        return $this;
    }

    public function getContattoFacebook(): ?string
    {
        return $this->contattoFacebook;
    }

    public function setContattoFacebook(?string $contattoFacebook): self
    {
        $this->contattoFacebook = $contattoFacebook;

        return $this;
    }

    public function getContattoEmail(): ?string
    {
        return $this->contattoEmail;
    }

    public function setContattoEmail(?string $contattoEmail): self
    {
        $this->contattoEmail = $contattoEmail;

        return $this;
    }

    public function getContattoInstagram(): ?string
    {
        return $this->contattoInstagram;
    }

    public function setContattoInstagram(?string $contattoInstagram): self
    {
        $this->contattoInstagram = $contattoInstagram;

        return $this;
    }

    public function getVideoYoutube(): ?string
    {
        return $this->videoYoutube;
    }

    public function setVideoYoutube(?string $videoYoutube): self
    {
        $this->videoYoutube = $videoYoutube;

        return $this;
    }

    public function getIdSpotify(): ?string
    {
        return $this->idSpotify;
    }

    public function setIdSpotify(?string $idSpotify): self
    {
        $this->idSpotify = $idSpotify;

        return $this;
    }

    /**
     * @return Collection<int, Album>
     */
    public function getAlbums(): Collection
    {
        return $this->albums;
    }

    public function addAlbum(Album $album): self
    {
        if (!$this->albums->contains($album)) {
            $this->albums->add($album);
            $album->setUser($this);
        }

        return $this;
    }

    public function removeAlbum(Album $album): self
    {
        if ($this->albums->removeElement($album)) {
            // set the owning side to null (unless already changed)
            if ($album->getUser() === $this) {
                $album->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Single>
     */
    public function getSingles(): Collection
    {
        return $this->singles;
    }

    public function addSingle(Single $single): self
    {
        if (!$this->singles->contains($single)) {
            $this->singles->add($single);
            $single->setUser($this);
        }

        return $this;
    }

    public function removeSingle(Single $single): self
    {
        if ($this->singles->removeElement($single)) {
            // set the owning side to null (unless already changed)
            if ($single->getUser() === $this) {
                $single->setUser(null);
            }
        }

        return $this;
    }
}
