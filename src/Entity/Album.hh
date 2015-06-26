<?hh

namespace MTP\Entity;

use \Doctrine\Common\Collections;

/** 
 * @Entity
 * @Table(name="albums")
 */
class Album
{
  /**
   * @Id
   * @GeneratedValue
   * @Column(type="integer")
   */
  private ?int $id;

  /**
   * @Column(type="string", length=1024)
   */
  private ?string $name;
  public function getName(): ?string { return $this->name; }
  public function setName(string $n) { $this->name = $n; }

  /**
   * @OneToMany(targetEntity="Song", mappedBy="album", cascade={"persist"})
   */
  protected Collections\Collection $songs;
  public function getSongs(): Collections\Collection { return $this->songs; }

  /**
   * @ManyToMany(targetEntity="Artist", inversedBy="albums", cascade={"persist"})
   * @JoinTable(name="album_artists",
   *     joinColumns={@JoinColumn(name="albumid", referencedColumnName="id")},
   *     inverseJoinColumns={@JoinColumn(name="artistid", referencedColumnName="id")}
   * )
   */
  protected Collections\Collection $artists;
  public function getArtists(): Collections\Collection { return $this->artists; }

  public function __construct()
  {
    $this->artists = new ArrayCollection();
    $this->songs   = new ArrayCollection();
  }

  public function addSong(Song $s)
  {
    $this->songs->add($s);
  }

  public function addArtist(Artist $a)
  {
    $this->artists->add($a);
  }
}

   

