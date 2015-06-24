<?hh

namespace MTP\Entity;

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
  protected ArrayCollection $songs;
  public function getSongs(): ArrayCollection { return $this->songs; }

  /**
   * @ManyToMany(targetEntity="Artist", inversedBy="albums", cascade={"persist"})
   * @JoinTable(name="album_artists",
   *     joinColumns={@JoinColumn(name="albumid", referencedColumnName="id")},
   *     inverseJoinColumns={@JoinColumn(name="artistid", referencedColumnName="id")}
   * )
   */
  protected ArrayCollection $artists;
  public function getArtists(): ArrayCollection { return $this->artists; }

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

   

