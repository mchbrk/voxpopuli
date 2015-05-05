<?php

namespace VP\VotingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use  Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Poll
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="VP\VotingBundle\Entity\PollRepository")
 */
class Poll
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="question", type="text")
     */
    private $question;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateStart", type="datetime")
     */
    private $dateStart;

    /**
     * @var \DateTime
     * @Assert\DateTime()
     * @ORM\Column(name="dateEnd", type="datetime")
     */
    private $dateEnd;

    /**
     * @ORM\OneToMany(targetEntity="Answer", mappedBy="poll", cascade={"persist", "remove"})
     */
    private $answers;

    /**
     * @ORM\OneToMany(targetEntity="Vote", mappedBy="poll")
     */
    private $votes;

     /**
     * @ORM\ManyToOne(targetEntity="VP\UserBundle\Entity\User", inversedBy="polls")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
    *
    *@ORM\Column(name="result", type="text")
    */
   // private $result;

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context)
    {
       
            if ($this->dateStart > $this->dateEnd){
                 $context->buildViolation('The ending date has already passed.')
                ->atPath('dateEnd')
                ->addViolation();
                return;
            }
            

    }

    public function __construct()
    {
        $this->answers = new ArrayCollection();
        $this->votes = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getName();

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
     * Set name
     *
     * @param string $name
     * @return Poll
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set question
     *
     * @param string $question
     * @return Poll
     */
    public function setQuestion($question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return string 
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set dateStart
     *
     * @param \DateTime $dateStart
     * @return Poll
     */
    public function setDateStart($dateStart)
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    /**
     * Get dateStart
     *
     * @return \DateTime 
     */
    public function getDateStart()
    {
        return $this->dateStart;
    }

    /**
     * Set dateEnd
     *
     * @param \DateTime $dateEnd
     * @return Poll
     */
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * Get dateEnd
     *
     * @return \DateTime 
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * Add answers
     *
     * @param \VP\VotingBundle\Entity\Answer $answers
     * @return Poll
     */
    public function addAnswer(\VP\VotingBundle\Entity\Answer $answers)
    {
        $this->answers[] = $answers;

        return $this;
    }

    /**
     * Remove answers
     *
     * @param \VP\VotingBundle\Entity\Answer $answers
     */
    public function removeAnswer(\VP\VotingBundle\Entity\Answer $answers)
    {
        $this->answers->removeElement($answers);
    }

    /**
     * Get answers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * Set user
     *
     * @param \VP\UserBundle\Entity\User $user
     * @return Poll
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
     * Add votes
     *
     * @param \VP\VotingBundle\Entity\Vote $votes
     * @return Poll
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
    public function getVotes()
    {
        return $this->votes;
    }
}
