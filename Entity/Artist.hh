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
   * @OneToMany(targetEntity="Album", mappedBy="artist")
   */
  protected $albums;
  public function getAlbums() { return $albums; }
}

   

