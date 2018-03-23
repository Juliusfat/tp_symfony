<?php

namespace AppBundle\Entity;

/**
 * Article
 */
class Article
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var string
     */
    private $nom;

    /**
     * @var string
     */
    private $description;

    /**
     * @var float
     */
    private $prix;

    /**
     * @var int
     */
    private $stockRestant;


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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Article
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Article
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Article
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set prix
     *
     * @param float $prix
     *
     * @return Article
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set stockRestant
     *
     * @param integer $stockRestant
     *
     * @return Article
     */
    public function setStockRestant($stockRestant)
    {
        $this->stockRestant = $stockRestant;

        return $this;
    }

    /**
     * Get stockRestant
     *
     * @return int
     */
    public function getStockRestant()
    {
        return $this->stockRestant;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $commandes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->commandes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->setCreatedAt(new \DateTime());
    }

    /**
     * Add commande
     *
     * @param \AppBundle\Entity\Commande $commande
     *
     * @return Article
     */
    public function addCommande(\AppBundle\Entity\Commande $commande)
    {
        $this->commandes[] = $commande;

        return $this;
    }

    /**
     * Remove commande
     *
     * @param \AppBundle\Entity\Commande $commande
     */
    public function removeCommande(\AppBundle\Entity\Commande $commande)
    {
        $this->commandes->removeElement($commande);
    }

    /**
     * Get commandes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommandes()
    {
        return $this->commandes;
    }
}
