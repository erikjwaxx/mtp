<?hh

namespace MTP\Entity;

use \Doctrine\ORM\PersistentCollection;

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
  private PersistentCollection $songs;
  public function getSongs(): PersistentCollection { return $this->songs; }
  public function addSong(Song $s) { $this->songs->add($s); }

  /**
   * @ManyToMany(targetEntity="Album", mappedBy="artists")
   * @JoinTable(name="album_artists",
   *     joinColumns={@JoinColumn(name="artistid", referencedColumnName="id")},
   *     inverseJoinColumns={@JoinColumn(name="albumid", referencedColumnName="id")}
   * )
   */
  private PersistentCollection $albums;
  public function getAlbums(): PersistentCollection { return $this->albums; }
  public function addAlbum(Album $a): void { $this->albums->add($a); }

  public function __construct()
  {
    $this->albums = new PersistentCollection();
    $this->songs  = new PersistentCollection();
  }
}

   

