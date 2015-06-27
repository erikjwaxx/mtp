<?hh

namespace MTP\Entity;

/** 
 * @Entity
 * @Table(name="songs")
 */
class Song
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
  protected ?string $name;
  public function getName(): ?string { return $this->name; }
  public function setName(string $n): void { $this->name = $n; }

  /**
   * @ManyToOne(targetEntity="Album", inversedBy="songs", cascade={"persist"})
   * @JoinColumn(name="albumid")
   */
  protected ?Album $album;
  public function getAlbum(): ?Album { return $this->album; }
  public function setAlbum(Album $a): void
  {
    $this->album = $a;
    $a->getSongs()->add($this);
  }

  /**
   * @ManyToOne(targetEntity="Artist", inversedBy="songs", cascade={"persist"})
   * @JoinColumn(name="artistid")
   */
  protected ?Artist $artist;
  public function getArtist(): ?Artist { return $this->artist; }
  public function setArtist(Artist $a): void
  {
    $this->artist = $a;
    $a->getSongs()->add($this);
  }
}

   

