<?php

namespace UJM\ExoBundle\Serializer\Answer\Type;

use JMS\DiExtraBundle\Annotation as DI;
use UJM\ExoBundle\Library\Serializer\SerializerInterface;

/**
 * @DI\Service("ujm_exo.serializer.answer_words")
 */
class WordsAnswerSerializer implements SerializerInterface
{
    /**
     * Converts a Words answer into a JSON-encodable structure.
     *
     * @param string $wordsAnswer
     * @param array $options
     *
     * @return \stdClass
     */
    public function serialize($wordsAnswer, array $options = [])
    {
        $answerData = new \stdClass();

        return $answerData;
    }

    /**
     * Converts raw data into a Words answer string.
     *
     * @param mixed  $data
     * @param string $wordsAnswer
     * @param array  $options
     *
     * @return string
     */
    public function deserialize($data, $wordsAnswer = null, array $options = [])
    {

    }
}
