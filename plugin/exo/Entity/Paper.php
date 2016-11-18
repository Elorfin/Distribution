<?php

namespace UJM\ExoBundle\Entity;

use Claroline\CoreBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use UJM\ExoBundle\Entity\Attempt\Answer;

/**
 * A paper represents an user attempt to a quiz.
 *
 * @ORM\Entity(repositoryClass="UJM\ExoBundle\Repository\PaperRepository")
 * @ORM\Table(name="ujm_paper")
 */
class Paper
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column("uuid", type="string", length=36, unique=true)
     */
    private $uuid;

    /**
     * @ORM\Column(name="num_paper", type="integer")
     */
    private $number = 1;

    /**
     * @ORM\Column(type="datetime")
     */
    private $start;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $end = null;

    /**
     * The generated structure (steps and questions) for the attempt.
     * 
     * @ORM\Column(name="ordre_question", type="text", nullable=true)
     */
    private $ordreQuestion;

    /**
     * @ORM\Column(name="interupt", type="boolean", nullable=true)
     */
    private $interrupted = true;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $score = null;

    /**
     * @ORM\Column(name="anonymous", type="boolean", nullable=true)
     */
    private $anonymous = false;

    /**
     * The user who made the attempt.
     * If this is the attempt for an anonymous user, this property is `null`.
     *
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Claroline\CoreBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     */
    private $user;

    /**
     * @var Exercise
     *
     * @ORM\ManyToOne(targetEntity="UJM\ExoBundle\Entity\Exercise")
     */
    private $exercise;

    /**
     * The submitted answers for this attempt.
     *
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="UJM\ExoBundle\Entity\Attempt\Answer", mappedBy="paper", orphanRemoval=true)
     */
    private $answers;

    /**
     * Paper constructor.
     */
    public function __construct()
    {
        $this->uuid = Uuid::uuid4();
        $this->start = new \DateTime();
        $this->answers = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Gets UUID.
     *
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Sets UUID.
     *
     * @param $uuid
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * Sets number.
     *
     * @param int $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * Gets number.
     *
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Sets start date.
     *
     * @param \DateTime $start
     */
    public function setStart(\DateTime $start)
    {
        $this->start = $start;
    }

    /**
     * Gets start date.
     *
     * @return \Datetime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @param \Datetime $end
     */
    public function setEnd($end)
    {
        $this->end = $end;
    }

    /**
     * @return \Datetime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Sets structure.
     *
     * @param string $structure
     */
    public function setStructure($structure)
    {
        $this->ordreQuestion = $structure;
    }

    /**
     * Gets structure.
     *
     * @return string
     */
    public function getStructure()
    {
        return $this->ordreQuestion;
    }

    /**
     * @deprecated
     *
     * @param string $ordreQuestion
     */
    public function setOrdreQuestion($ordreQuestion)
    {
        $this->ordreQuestion = $ordreQuestion;
    }

    /**
     * @deprecated
     *
     * @return string
     */
    public function getOrdreQuestion()
    {
        return $this->ordreQuestion;
    }

    /**
     * @param bool $interrupted
     */
    public function setInterrupted($interrupted)
    {
        $this->interrupted = $interrupted;
    }

    /**
     * @return bool
     */
    public function isInterrupted()
    {
        return $this->interrupted;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;
    }

    /**
     * @return Exercise
     */
    public function getExercise()
    {
        return $this->exercise;
    }

    /**
     * @param Exercise $exercise
     */
    public function setExercise(Exercise $exercise)
    {
        $this->exercise = $exercise;
    }

    /**
     * @param float $score
     */
    public function setScore($score)
    {
        $this->score = $score;
    }

    /**
     * @return float
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set anonymous.
     *
     * @param bool $anonymous
     */
    public function setAnonymous($anonymous)
    {
        $this->anonymous = $anonymous;
    }

    /**
     * Is anonymous.
     */
    public function isAnonymous()
    {
        return $this->anonymous;
    }

    /**
     * Gets answers.
     *
     * @return ArrayCollection
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * Adds an answer.
     *
     * @param Answer $answer
     */
    public function addAnswer(Answer $answer)
    {
        if (!$this->answers->contains($answer)) {
            $this->answers->add($answer);
        }
    }

    /**
     * Removes an answer.
     *
     * @param Answer $answer
     */
    public function removeAnswer(Answer $answer)
    {
        if ($this->answers->contains($answer)) {
            $this->answers->removeElement($answer);
        }
    }
}
