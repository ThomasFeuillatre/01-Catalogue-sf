<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categorie
 *
 * @ORM\Table(name="categorie")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategorieRepository")
 */
class Categorie
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
     * @var string
     *
     * @ORM\Column(name="Titre", type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\OneToMany(targetEntity="Jeu", mappedBy="categorie")
     */
    private $jeu;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Categorie
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->jeu = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add jeu
     *
     * @param \AppBundle\Entity\Jeu $jeu
     *
     * @return Categorie
     */
    public function addJeu(\AppBundle\Entity\Jeu $jeu)
    {
        $this->jeu[] = $jeu;

        return $this;
    }

    /**
     * Remove jeu
     *
     * @param \AppBundle\Entity\Jeu $jeu
     */
    public function removeJeu(\AppBundle\Entity\Jeu $jeu)
    {
        $this->jeu->removeElement($jeu);
    }

    /**
     * Get jeu
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getJeu()
    {
        return $this->jeu;
    }
}
