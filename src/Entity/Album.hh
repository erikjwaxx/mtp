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
   * @Column(type="integer", precision=7)
   */
  protected ?int $id;
  public function getId(): int { return $id; }

  /**
   * @OneToMany(targetEntity="Song", mappedBy="album")
   */
  protected $songs;
  public function getSongs() { return $songs; }

  /**
   * @OneToOne(targetEntity="Artist")
   */
  protected Artist $artist;
  public function getArtist(): Artist { return $artist; }
}

   

