<?php

namespace EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Chapter
 *
 * @ORM\Table(name="chapter")
 * @ORM\Entity(repositoryClass="EntityBundle\Repository\ChapterRepository")
 */
class Chapter
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
     * @ORM\ManyToOne(targetEntity="Book", inversedBy="features")
     * @ORM\JoinColumn(name="book_chapter", referencedColumnName="id")
     */
    private $book;

    /**
     * @ORM\OneToMany(targetEntity="Verse", mappedBy="Chapter")
     */
    private $verses;


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
     * @return Chapter
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
     * Constructor
     */
    public function __construct()
    {
        $this->verses = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set book
     *
     * @param \EntityBundle\Entity\Book $book
     * @return Chapter
     */
    public function setBook(\EntityBundle\Entity\Book $book = null)
    {
        $this->book = $book;

        return $this;
    }

    /**
     * Get book
     *
     * @return \EntityBundle\Entity\Book 
     */
    public function getBook()
    {
        return $this->book;
    }

    /**
     * Add verses
     *
     * @param \EntityBundle\Entity\Verse $verses
     * @return Chapter
     */
    public function addVerse(\EntityBundle\Entity\Verse $verses)
    {
        $this->verses[] = $verses;

        return $this;
    }

    /**
     * Remove verses
     *
     * @param \EntityBundle\Entity\Verse $verses
     */
    public function removeVerse(\EntityBundle\Entity\Verse $verses)
    {
        $this->verses->removeElement($verses);
    }

    /**
     * Get verses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVerses()
    {
        return $this->verses;
    }
}
