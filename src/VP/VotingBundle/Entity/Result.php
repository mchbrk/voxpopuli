<?php

namespace VP\VotingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use  Doctrine\Common\Collections\ArrayCollection;

/**
 * Result
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="VP\VotingBundle\Entity\ResultRepository")
 */
class Result
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
     * @ORM\Column(name="random", type="integer")
     */
    private $random;

    /**
     * @ORM\OneToOne(targetEntity="Poll")
     * @ORM\JoinColumn(name="poll_id", referencedColumnName="id")
     **/
    private $poll;


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
     * Set random
     *
     * @param integer $random
     * @return Result
     */
    public function setRandom($random)
    {
        $this->random = $random;

        return $this;
    }

    /**
     * Get random
     *
     * @return integer 
     */
    public function getRandom()
    {
        return $this->random;
    }

    /**
     * Set poll
     *
     * @param \VP\VotingBundle\Entity\Poll $poll
     * @return Result
     */
    public function setPoll(\VP\VotingBundle\Entity\Poll $poll = null)
    {
        $this->poll = $poll;

        return $this;
    }

    /**
     * Get poll
     *
     * @return \VP\VotingBundle\Entity\Poll 
     */
    public function getPoll()
    {
        return $this->poll;
    }
}
