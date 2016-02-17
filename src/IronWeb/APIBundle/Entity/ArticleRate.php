<?php

namespace IronWeb\APIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ArticleRate
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="IronWeb\APIBundle\Entity\ArticleRateRepository")
 * @ExclusionPolicy("all")
 */
class ArticleRate
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="rate", type="integer")
     * @Assert\Range(
     *      min = 0,
     *      max = 5
     * )
     * @Expose
     */
    private $rate;

    /**
     * @ORM\ManyToOne(targetEntity="IronWeb\APIBundle\Entity\Article", inversedBy="rates")
     * @ORM\JoinColumn(nullable=false)
     */
    private $article;


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
     * Set rate
     *
     * @param integer $rate
     * @return ArticleRate
     */
    public function setRate($rate)
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * Get rate
     *
     * @return integer 
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * Set article
     *
     * @param \IronWeb\APIBundle\Entity\Article $article
     * @return ArticleRate
     */
    public function setArticle(\IronWeb\APIBundle\Entity\Article $article)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return \IronWeb\APIBundle\Entity\Article 
     */
    public function getArticle()
    {
        return $this->article;
    }
}
