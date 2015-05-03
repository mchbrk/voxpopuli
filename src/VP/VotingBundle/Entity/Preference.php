<?php

namespace VP\VotingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Preference
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="VP\VotingBundle\Entity\PreferenceRepository")
 */
class Preference
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
     * @ORM\Column(name="rank", type="integer")
     */
    private $rank;

    /**
     * @var boolean
     *
     * @ORM\Column(name="approved", type="boolean", nullable=true)
     */
    private $approved;

    /**
     * @var integer
     *
     * @ORM\Column(name="negative", type="integer", nullable=true )
     */
    private $negative;


     /**
     * @ORM\ManyToOne(targetEntity="Answer", inversedBy="preferences")
     * @ORM\JoinColumn(name="answer_id", referencedColumnName="id")
     */

    private $answer;

     /**
     * @ORM\ManyToOne(targetEntity="Vote", inversedBy="preferences")
     * @ORM\JoinColumn(name="vote_id", referencedColumnName="id")
     */
    private $vote;

    /**
     * @var string
     */
    private $content;

    public function __toString()
    {
        return $this->getContent();

    }

    public function __construct(){
        $this->content = "Option";
    }

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
     * Set rank
     *
     * @param integer $rank
     * @return Preference
     */
    public function setRank($rank)
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * Get rank
     *
     * @return integer 
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * Set approved
     *
     * @param boolean $approved
     * @return Preference
     */
    public function setApproved($approved)
    {
        $this->approved = $approved;

        return $this;
    }

    /**
     * Get approved
     *
     * @return boolean 
     */
    public function getApproved()
    {
        return $this->approved;
    }

    /**
     * Set negative
     *
     * @param integer $negative
     * @return Preference
     */
    public function setNegative($negative)
    {
        $this->negative = $negative;

        return $this;
    }

    /**
     * Get negative
     *
     * @return integer 
     */
    public function getNegative()
    {
        return $this->negative;
    }
    
    /**
     * Set answer
     *
     * @param \VP\VotingBundle\Entity\Answer $answer
     * @return Preference
     */
    public function setAnswer(\VP\VotingBundle\Entity\Answer $answer = null)
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * Get answer
     *
     * @return \VP\VotingBundle\Entity\Answer 
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Set vote
     *
     * @param \VP\VotingBundle\Entity\Vote $vote
     * @return Preference
     */
    public function setVote(\VP\VotingBundle\Entity\Vote $vote = null)
    {
        $this->vote = $vote;

        return $this;
    }

    /**
     * Get vote
     *
     * @return \VP\VotingBundle\Entity\Vote 
     */
    public function getVote()
    {
        return $this->vote;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

      /**
     * Set content
     *
     * @param string $content
     * @return Preference
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }


}
