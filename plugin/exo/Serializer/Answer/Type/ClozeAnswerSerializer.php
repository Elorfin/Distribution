<?php

namespace UJM\ExoBundle\Serializer\Answer\Type;

use JMS\DiExtraBundle\Annotation as DI;
use UJM\ExoBundle\Library\Serializer\SerializerInterface;

/**
 * @DI\Service("ujm_exo.serializer.answer_cloze")
 */
class ClozeAnswerSerializer implements SerializerInterface
{
    /**
     * Converts a Cloze answer into a JSON-encodable structure.
     *
     * @param string $clozeAnswer
     * @param array $options
     *
     * @return \stdClass
     */
    public function serialize($clozeAnswer, array $options = [])
    {
        $answerData = new \stdClass();

        return $answerData;
    }

    /**
     * Converts raw data into a Cloze answer string.
     *
     * @param mixed  $data
     * @param string $clozeAnswer
     * @param array  $options
     *
     * @return string
     */
    public function deserialize($data, $clozeAnswer = null, array $options = [])
    {

    }
}
