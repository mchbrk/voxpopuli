<?php

namespace VP\VotingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Vote
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="VP\VotingBundle\Entity\VoteRepository")
 */
class Vote
{
     /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @ORM\OneToMany(targetEntity="Preference", mappedBy="vote", cascade={"persist", "remove"})
     */
    private $preferences;

     /**
     * @ORM\ManyToOne(targetEntity="VP\UserBundle\Entity\User", inversedBy="votes")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Poll", inversedBy="votes")
     * @ORM\JoinColumn(name="poll_id", referencedColumnName="id")
     */
    private $poll;

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context)
    {
        //checking if each preference points to different answer
        $answers = array();
        foreach ($this->getPreferences() as $preference){
            if (in_array($preference->getAnswer(), $answers)){
                 $context->buildViolation('Each option can be chosen only once.')
                ->atPath('preferences')
                ->addViolation();
                return;
            }
            array_push($answers, $preference->getAnswer());
        }
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
     * Set date
     *
     * @param \DateTime $date
     * @return Vote
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->preferences = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add preferences
     *
     * @param \VP\VotingBundle\Entity\Preference $preferences
     * @return Vote
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

    /**
     * Set user
     *
     * @param \VP\UserBundle\Entity\User $user
     * @return Vote
     */
    public function setUser(\VP\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \VP\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set poll
     *
     * @param \VP\VotingBundle\Entity\Poll $poll
     * @return Vote
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
