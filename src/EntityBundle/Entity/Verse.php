<?php

namespace EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Verse
 *
 * @ORM\Table(name="verse")
 * @ORM\Entity(repositoryClass="EntityBundle\Repository\VerseRepository")
 */
class Verse
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="number", type="integer")
     */
    private $number;

    /**
     * @ORM\ManyToOne(targetEntity="Chapter", inversedBy="verses")
     * @ORM\JoinColumn(name="chapter_verse", referencedColumnName="id")
     */
    private $chapter;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set number
     *
     * @param integer $number
     * @return Verse
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer 
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set chapter
     *
     * @param \EntityBundle\Entity\Chapter $chapter
     * @return Verse
     */
    public function setChapter(\EntityBundle\Entity\Chapter $chapter = null)
    {
        $this->chapter = $chapter;

        return $this;
    }

    /**
     * Get chapter
     *
     * @return \EntityBundle\Entity\Chapter 
     */
    public function getChapter()
    {
        return $this->chapter;
    }
}
