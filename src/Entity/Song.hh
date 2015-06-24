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
   * @Column(type="integer", precision=7)
   */
  protected ?int $id;
  public function getId(): int { return $id; }

  /**
   * @Column(type="string", length=1024)
   */
  protected string $name;
  public function getName(): string { return $name; }

  /**
   * @ManyToOne(targetEntity="Album", inversedBy="songs")
   */
  protected Album $album;
  public function getAlbum(): Album { return $album; }
}

   

