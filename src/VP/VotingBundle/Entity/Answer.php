<?php

namespace VP\VotingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Answer
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="VP\VotingBundle\Entity\AnswerRepository")
 */
class Answer
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
     * @var string
     *
     * @ORM\Column(name="content", type="string", length=255)
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="Poll", inversedBy="answers")
     * @ORM\JoinColumn(name="poll_id", referencedColumnName="id")
     */
    protected $poll;

    /**
     * @ORM\OneToMany(targetEntity="Preference", mappedBy="answer")
     */
    protected $preferences;

     public function __construct()
    {
        $this->preferences = new ArrayCollection();
    }

 public function __toString()
    {
        return $this->getContent();

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
     * Set content
     *
     * @param string $content
     * @return Answer
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
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
     * Set poll
     *
     * @param \VP\VotingBundle\Entity\Poll $poll
     * @return Answer
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

    /**
     * Add preferences
     *
     * @param \VP\VotingBundle\Entity\Preference $preferences
     * @return Answer
     */
    public function addPreference(\VP\VotingBundle\Entity\Preference $preferences)
    {
        $this->preferences[] = $preferences;

        return $this;
    }

    /**
     * Remove preferences
     *
     * @param \VP\VotingBundle\Entity\Preference $preferences
     */
    public function removePreference(\VP\VotingBundle\Entity\Preference $preferences)
    {
        $this->preferences->removeElement($preferences);
    }

    /**
     * Get preferences
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPreferences()
    {
        return $this->preferences;
    }
}
