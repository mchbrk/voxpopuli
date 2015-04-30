<?php
// src/Acme/UserBundle/Entity/User.php

namespace VP\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="VP\UserBundle\Entity\UserRepository")
 * @ORM\Table(name="lcl_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /** @ORM\Column(name="facebook_id", type="string", length=255, nullable=true) */
    protected $facebook_id;

    /** @ORM\Column(name="facebook_access_token", type="string", length=255, nullable=true) */
    protected $facebook_access_token;  

    /**
     * @ORM\OneToMany(targetEntity="VP\VotingBundle\Entity\Poll", mappedBy="user")
     */
    private $polls;

    /**
     * @ORM\OneToMany(targetEntity="VP\VotingBundle\Entity\Vote", mappedBy="user")
     */
    private $votes;   
    
    //YOU CAN ADD MORE CODE HERE !

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
     * Set facebook_id
     *
     * @param string $facebookId
     * @return User
     */
    public function setFacebookId($facebookId)
    {
        $this->facebook_id = $facebookId;

        return $this;
    }

    /**
     * Get facebook_id
     *
     * @return string 
     */


    public function getFacebookId()
    {
        return $this->facebook_id;
    }

    /**
     * Set facebook_access_token
     *
     * @param string $facebookAccessToken
     * @return User
     */
    public function setFacebookAccessToken($facebookAccessToken)
    {
        $this->facebook_access_token = $facebookAccessToken;

        return $this;
    }

    /**
     * Get facebook_access_token
     *
     * @return string 
     */
    public function getFacebookAccessToken()
    {
        return $this->facebook_access_token;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->polls = new \Doctrine\Common\Collections\ArrayCollection();
        $this->votes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add polls
     *
     * @param \VP\VotingBundle\Entity\Poll $polls
     * @return User
     */
    public function addPoll(\VP\VotingBundle\Entity\Poll $polls)
    {
        $this->polls[] = $polls;

        return $this;
    }

    /**
     * Remove polls
     *
     * @param \VP\VotingBundle\Entity\Poll $polls
     */
    public function removePoll(\VP\VotingBundle\Entity\Poll $polls)
    {
        $this->polls->removeElement($polls);
    }

    /**
     * Get polls
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPolls()
    {
        return $this->polls;
    }

    /**
     * Add votes
     *
     * @param \VP\VotingBundle\Entity\Vote $votes
     * @return User
     */
    public function addVote(\VP\VotingBundle\Entity\Vote $votes)
    {
        $this->votes[] = $votes;

        return $this;
    }

    /**
     * Remove votes
     *
     * @param \VP\VotingBundle\Entity\Vote $votes
     */
    public function removeVote(\VP\VotingBundle\Entity\Vote $votes)
    {
        $this->votes->removeElement($votes);
    }

    /**
     * Get votes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVote()
    {
        return $this->votes;
    }

    /**
     * Get votes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVotes()
    {
        return $this->votes;
    }
}
