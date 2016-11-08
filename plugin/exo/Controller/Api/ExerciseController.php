<?php

namespace UJM\ExoBundle\Controller\Api;

use Claroline\CoreBundle\Entity\User;
use Claroline\CoreBundle\Library\Security\Collection\ResourceCollection;
use Claroline\CoreBundle\Persistence\ObjectManager;
use JMS\DiExtraBundle\Annotation as DI;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as EXT;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use UJM\ExoBundle\Entity\Exercise;
use UJM\ExoBundle\Library\Options\Transfer;
use UJM\ExoBundle\Manager\ExerciseManager;
use UJM\ExoBundle\Manager\PaperManager;
use UJM\ExoBundle\Manager\Question\QuestionManager;
use UJM\ExoBundle\Services\classes\PaperService;
use UJM\ExoBundle\Transfer\Json\ValidationException;

/**
 * Exercise API Controller exposes REST API.
 *
 * @EXT\Route(
 *     "/exercises",
 *     options={"expose"=true},
 *     defaults={"_format": "json"}
 * )
 * @EXT\Method("GET")
 */
class ExerciseController
{
    private $om;
    private $authorization;
    private $exerciseManager;
    private $questionManager;
    private $paperManager;
    private $paperService;
    private $translator;

    /**
     * @DI\InjectParams({
     *     "om"                 = @DI\Inject("claroline.persistence.object_manager"),
     *     "authorization"      = @DI\Inject("security.authorization_checker"),
     *     "exerciseManager"    = @DI\Inject("ujm.exo.exercise_manager"),
     *     "questionManager"    = @DI\Inject("ujm.exo.question_manager"),
     *     "paperManager"       = @DI\Inject("ujm.exo.paper_manager"),
     *     "paperService"       = @DI\Inject("ujm.exo_paper"),
     *     "translator"         = @DI\Inject("translator.default")
     * })
     *
     * @param ObjectManager                 $om
     * @param AuthorizationCheckerInterface $authorization
     * @param ExerciseManager               $exerciseManager
     * @param QuestionManager               $questionManager
     * @param PaperManager                  $paperManager
     * @param PaperService                  $paperService
     * @param Translator                    $translator
     */
    public function __construct(
        ObjectManager $om,
        AuthorizationCheckerInterface $authorization,
        ExerciseManager $exerciseManager,
        QuestionManager $questionManager,
        PaperManager $paperManager,
        PaperService $paperService,
        Translator $translator
    ) {
        $this->om = $om;
        $this->authorization = $authorization;
        $this->exerciseManager = $exerciseManager;
        $this->questionManager = $questionManager;
        $this->paperManager = $paperManager;
        $this->paperService = $paperService;
        $this->translator = $translator;
    }

    /**
     * Exports the full representation of an exercise (including solutions)
     * in a JSON format.
     *
     * @EXT\Route("/{id}", name="exercise_get")
     * @EXT\ParamConverter("exercise", class="UJMExoBundle:Exercise", options={"mapping": {"id": "uuid"}})
     *
     * @param Exercise $exercise
     *
     * @return JsonResponse
     */
    public function exportAction(Exercise $exercise)
    {
        $this->assertHasPermission('ADMINISTRATE', $exercise);

        return new JsonResponse($this->exerciseManager->export($exercise, [Transfer::INCLUDE_SOLUTIONS]));
    }

    /**
     * Updates an Exercise.
     *
     * @EXT\Route("/{id}", name="exercise_update")
     * @EXT\ParamConverter("exercise", class="UJMExoBundle:Exercise", options={"mapping": {"id": "uuid"}})
     * @EXT\Method("PUT")
     *
     * @param Exercise $exercise
     * @param Request  $request
     *
     * @return JsonResponse
     */
    public function updateAction(Exercise $exercise, Request $request)
    {
        $this->assertHasPermission('ADMINISTRATE', $exercise);

        $dataRaw = $request->getContent();

        if ($dataRaw) {
            $data = json_decode($dataRaw);
            if (null === $data) {
                return new JsonResponse([[
                    'path' => '',
                    'message' => 'Invalid JSON data',
                ]], 422);
            }

            try {
                $this->exerciseManager->update($exercise, $data);
            } catch (ValidationException $e) {
                return new JsonResponse($e->getErrors(), 422);
            }
        }

        return new JsonResponse($this->exerciseManager->export($exercise, [Transfer::INCLUDE_SOLUTIONS]));
    }

    /**
     * Update the properties of an Exercise.
     *
     * @EXT\Route("/{id}/update", name="exercise_update_meta", requirements={"id"="\d+"})
     * @EXT\Method("PUT")
     *
     * @param Exercise $exercise
     * @param Request  $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateMetadataAction(Exercise $exercise, Request $request)
    {
        $this->assertHasPermission('ADMINISTRATE', $exercise);

        // Get Exercise data from the Request
        $dataRaw = $request->getContent();
        if (!empty($dataRaw)) {
            $this->exerciseManager->updateMetadata($exercise, json_decode($dataRaw));
        }

        return new JsonResponse($this->exerciseManager->exportExercise($exercise, false));
    }

    /**
     * Publishes an exercise.
     *
     * @EXT\Route(
     *     "/{id}/publish",
     *     name="exercise_publish",
     *     requirements={"id"="\d+"},
     *     options={"expose"=true}
     * )
     * @EXT\Method("POST")
     *
     * @param Exercise $exercise
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function publishAction(Exercise $exercise)
    {
        $this->assertHasPermission('ADMINISTRATE', $exercise);

        $this->exerciseManager->publish($exercise);

        return new JsonResponse($this->exerciseManager->exportExercise($exercise, false));
    }

    /**
     * Unpublishes an exercise.
     *
     * @EXT\Route(
     *     "/{id}/unpublish",
     *     name="exercise_unpublish",
     *     requirements={"id"="\d+"},
     *     options={"expose"=true}
     * )
     * @EXT\Method("POST")
     *
     * @param Exercise $exercise
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function unpublishAction(Exercise $exercise)
    {
        $this->assertHasPermission('ADMINISTRATE', $exercise);

        $this->exerciseManager->unpublish($exercise);

        return new JsonResponse($this->exerciseManager->exportExercise($exercise, false));
    }

    /**
     * Opens an exercise, creating a new paper or re-using an unfinished one.
     * Also check that max attempts are not reached if needed.
     *
     * @EXT\Route("/{id}/attempts", name="exercise_new_attempt", requirements={"id"="\d+"})
     * @EXT\Method("POST")
     * @EXT\ParamConverter("user", converter="current_user", options={"allowAnonymous"=true})
     *
     * @param Exercise $exercise
     * @param User     $user
     *
     * @return JsonResponse
     */
    public function attemptAction(Exercise $exercise, User $user = null)
    {
        $this->assertHasPermission('OPEN', $exercise);

        // if not admin of the resource check if exercise max attempts is reached
        if (!$this->isAdmin($exercise) && $user) {
            $max = $exercise->getMaxAttempts();
            $nbFinishedPapers = $this->paperManager->countUserFinishedPapers($exercise, $user);

            if ($max > 0 && $nbFinishedPapers >= $max) {
                throw new AccessDeniedHttpException('max attempts reached');
            }
        }

        $paper = $this->paperManager->openPaper($exercise, $user);

        return new JsonResponse([
            'paper' => $this->paperManager->exportPaper($paper, $this->isAdmin($paper->getExercise())),
            'questions' => $this->paperManager->exportPaperQuestions($paper, $this->isAdmin($paper->getExercise())),
        ]);
    }

    /**
     * Returns all the papers associated with an exercise for the current user.
     *
     * @EXT\Route("/{id}/papers", name="exercise_papers", requirements={"id"="\d+"})
     * @EXT\ParamConverter("user", converter="current_user")
     *
     * @param User     $user
     * @param Exercise $exercise
     *
     * @return JsonResponse
     */
    public function papersAction(User $user, Exercise $exercise)
    {
        $this->assertHasPermission('OPEN', $exercise);

        if ($this->isAdmin($exercise)) {
            return new JsonResponse($this->paperManager->exportExercisePapers($exercise));
        }

        return new JsonResponse($this->paperManager->exportExercisePapers($exercise, $user));
    }

    /**
     * Exports papers into a CSV format.
     *
     * @EXT\Route("/{id}/papers/export", name="exercise_papers_export", requirements={"id"="\d+"})
     *
     * @param Exercise $exercise
     *
     * @return Response
     */
    public function papersExportAction(Exercise $exercise)
    {
        $this->assertHasPermission('ADMINISTRATE', $exercise);

        $iterableResult = $this->om->getRepository('UJMExoBundle:Paper')
            ->getExerciseAllPapersIterator($exercise->getId());

        $handle = fopen('php://memory', 'r+');
        while (false !== ($row = $iterableResult->next())) {
            $rowCSV = [];
            $infosPaper = $this->paperService->getInfosPaper($row[0]);
            $score = $infosPaper['scorePaper'] / $infosPaper['maxExoScore'];
            $score = $score * 20;

            $rowCSV[] = $row[0]->getUser()->getLastName().'-'.$row[0]->getUser()->getFirstName();
            $rowCSV[] = $row[0]->getNumPaper();
            $rowCSV[] = $row[0]->getStart()->format('Y-m-d H:i:s');
            if ($row[0]->getEnd()) {
                $rowCSV[] = $row[0]->getEnd()->format('Y-m-d H:i:s');
            } else {
                $rowCSV[] = $this->translator->trans('no_finish', [], 'ujm_exo');
            }
            $rowCSV[] = $row[0]->getInterupt();
            $rowCSV[] = $this->paperService->roundUpDown($score);

            fputcsv($handle, $rowCSV);
            $this->om->detach($row[0]);
        }

        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return new Response($content, 200, [
            'Content-Type' => 'application/force-download',
            'Content-Disposition' => 'attachment; filename="export.csv"',
        ]);
    }

    /**
     * Deletes all the papers associated with an exercise.
     *
     * @EXT\Route(
     *     "/{id}/papers",
     *     name="ujm_exercise_delete_papers",
     *     options={"expose"=true}
     * )
     * @EXT\Method("DELETE")
     *
     * @param Exercise $exercise
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function papersDeleteAction(Exercise $exercise)
    {
        $this->assertHasPermission('ADMINISTRATE', $exercise);

        $this->exerciseManager->deletePapers($exercise);

        return new JsonResponse([]);
    }

    private function assertHasPermission($permission, Exercise $exercise)
    {
        $collection = new ResourceCollection([$exercise->getResourceNode()]);

        if (!$this->authorization->isGranted($permission, $collection)) {
            throw new AccessDeniedHttpException();
        }
    }

    private function isAdmin(Exercise $exercise)
    {
        $collection = new ResourceCollection([$exercise->getResourceNode()]);

        return $this->authorization->isGranted('ADMINISTRATE', $collection);
    }
}
