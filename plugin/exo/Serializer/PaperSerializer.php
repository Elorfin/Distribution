<?php

namespace UJM\ExoBundle\Serializer;

use JMS\DiExtraBundle\Annotation as DI;
use UJM\ExoBundle\Entity\Attempt\Answer;
use UJM\ExoBundle\Entity\Attempt\Paper;
use UJM\ExoBundle\Library\Options\Transfer;
use UJM\ExoBundle\Library\Serializer\AbstractSerializer;
use UJM\ExoBundle\Serializer\Answer\AnswerSerializer;

/**
 * Serializer for paper data.
 *
 * @DI\Service("ujm_exo.serializer.paper")
 */
class PaperSerializer extends AbstractSerializer
{
    /**
     * @var UserSerializer
     */
    private $userSerializer;

    /**
     * @var AnswerSerializer
     */
    private $answerSerializer;

    /**
     * PaperSerializer constructor.
     *
     * @param UserSerializer $userSerializer
     * @param AnswerSerializer $answerSerializer
     *
     * @DI\InjectParams({
     *     "userSerializer" = @DI\Inject("ujm_exo.serializer.user"),
     *     "answerSerializer" = @DI\Inject("ujm_exo.serializer.answer")
     * })
     */
    public function __construct(
        UserSerializer $userSerializer,
        AnswerSerializer $answerSerializer)
    {
        $this->userSerializer = $userSerializer;
        $this->answerSerializer = $answerSerializer;
    }

    /**
     * Converts a Paper into a JSON-encodable structure.
     *
     * @param Paper $paper
     * @param array $options
     *
     * @return \stdClass
     */
    public function serialize($paper, array $options = [])
    {
        $paperData = new \stdClass();

        $this->mapEntityToObject([
            'id' => 'uuid',
            'number' => 'number',
            'finished' => function (Paper $paper) {
                return !$paper->isInterrupted();
            },
            'user' => function (Paper $paper) use ($options) {
                $user = $paper->getUser();
                if ($user && !$paper->isAnonymized()) {
                    $userData = $this->userSerializer->serialize($user, $options);
                } else {
                    $userData = null;
                }

                return $userData;
            },
            'startDate' => function (Paper $paper) {
                return $paper->getStart()->format('Y-m-d\TH:i:s');
            },
            'endDate' => function (Paper $paper) {
                return $paper->getEnd() ? $paper->getEnd()->format('Y-m-d\TH:i:s') : null;
            },
            'structure' => function (Paper $paper) {
                return $this->serializeStructure($paper);
            },
        ], $paper, $paperData);

        // Adds detail information
        if (!$this->hasOption(Transfer::MINIMAL, $options)) {
            $this->mapEntityToObject([
                'answers' => function (Paper $paper) use ($options) {
                    return $this->serializeAnswers($paper, $options);
                },
            ], $paper, $paperData);
        }

        // Adds user score
        if ($this->hasOption(Transfer::INCLUDE_USER_SCORE, $options)) {
            $this->mapEntityToObject([
                'score' => 'score',
            ], $paper, $paperData);
        }

        return $paperData;
    }

    /**
     * Converts raw data into a Paper entity.
     *
     * @param \stdClass $data
     * @param Paper     $paper
     * @param array     $options
     *
     * @return Paper
     */
    public function deserialize($data, $paper = null, array $options = [])
    {
        if (empty($paper)) {
            $paper = new Paper();
        }

        return $paper;
    }

    /**
     * Serializes paper answers.
     *
     * @param Paper $paper
     * @param array $options
     *
     * @return array
     */
    private function serializeAnswers(Paper $paper, array $options = [])
    {
        $answers = $paper->getAnswers()->toArray();

        return array_map(function (Answer $answer) use ($options) {
            return $this->answerSerializer->serialize($answer, $options);
        }, $answers);
    }

    private function serializeStructure(Paper $paper)
    {

    }
}
