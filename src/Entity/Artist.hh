<?hh

namespace MTP\Entity;

use \Doctrine\Common\Collections;

/** 
 * @Entity
 * @Table(name="artists")
 */
class Artist
{
  /**
   * @Id
   * @GeneratedValue
   * @Column(type="integer", precision=7)
   */
  private ?int $id;

  /**
   * @Column(type="string", length=1024)
   */
  private ?string $name;
  public function getName(): ?string { return $this->name; }
  public function setName(string $n) { $this->name = $n; }

  /**
   * @OneToMany(targetEntity="Song", mappedBy="artist")
   */
  private Collections\Collection $songs;
  public function getSongs(): Collections\Collection { return $this->songs; }
  public function addSong(Song $s)
  {
    $s->setArtist($this);
    $this->songs->add($s);
  }

  /**
   * @ManyToMany(targetEntity="Album", mappedBy="artists")
   * @JoinTable(name="album_artists",
   *     joinColumns={@JoinColumn(name="artistid", referencedColumnName="id")},
   *     inverseJoinColumns={@JoinColumn(name="albumid", referencedColumnName="id")}
   * )
   */
  private Collections\Collection $albums;
  public function getAlbums(): Collections\Collection { return $this->albums; }
  public function addAlbum(Album $a): void
  {
    $a->addArtist($this);
    $this->albums->add($a);
  }

  public function __construct()
  {
    $this->albums = new Collections\ArrayCollection();
    $this->songs  = new Collections\ArrayCollection();
  }
}

   

