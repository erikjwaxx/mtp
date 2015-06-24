<?hh
namespace MTP\Entity;

/**
 * @Entity
 * @Table(name="matches")
 */
class Match
{
  /**
   * @Id
   * @GeneratedValue
   * @Column(type="integer")
   */
  private ?int $id;

  /**
   * @OneToOne(targetEntity="Song")
   * @JoinColumn(name="winnerid")
   */
  private ?Song $winner;
  public function getWinner(): ?Song { return $this->winner; }
  public function setWinner(Song $w): void { $this->winner = $w; }

  /**
   * @OneToOne(targetEntity="Song")
   * @JoinColumn(name="loserid")
   */
  private ?Song $loser;
  public function getLoser(): ?Song { return $this->loser; }
  public function setLoser(Song $l): void { $this->loser = $l; }

  /**
   * @Column(type="integer", name="margin_of_victory")
   */
  private ?int $marginOfVictory;
  public function getMarginOfVictory(): ?int { return $this->marginOfVictory; }
  public function setMarginOfVictory(int $m): void { $this->marginOfVictory = $m; }
}
  
