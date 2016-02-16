<?php

namespace IronWeb\APIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ArticleRate
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="IronWeb\APIBundle\Entity\ArticleRateRepository")
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
     */
    private $rate;

    /**
     * @ORM\ManyToOne(targetEntity="IronWeb\APIBundle\Entity\Article")
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
}
