<?php

namespace Icap\BlogBundle\Controller\API;

use FOS\RestBundle\Controller\Annotations\NamePrefix;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\FOSRestController;
use Hateoas\Representation\Factory\PagerfantaFactory;
use Icap\BlogBundle\Entity\Blog;
use JMS\Serializer\SerializationContext;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @NamePrefix("icap_blog_api_")
 */
class PostController extends FOSRestController
{
    const SERIALIZATION_FORMAT = 'json';
    const SERIALIZATION_GROUPS = ['blog_list', 'api_user_min'];

    /**
     * @Route(
     *     requirements={ "blog" = "\d+", "postId" = "\d+" },
     *     defaults={ "postId" = null, "_format" = "json" }
     * )
     */
    public function getBlogPostAction(Blog $blog, $postId)
    {
        $this->checkAccess('OPEN', $blog);

        $response = new JsonResponse();
        $serializer = $this->get('jms_serializer');
        $postRepository = $this->get('icap.blog.post_repository');

        // No post ID provided in route => get all posts for this blog
        if (is_null($postId)) {

            // Add pagerfanta

            $query = $postRepository
                ->createQueryBuilder('post')
                ->select(['post', 'author'])
                ->join('post.author', 'author')
                ->andWhere('post.blog = :blogId')
                ->setParameter('blogId', $blog->getId());

            $adapter = new DoctrineORMAdapter($query);
            $pager = new PagerFanta($adapter);
            $pager->setCurrentPage(1);
            $pager->setMaxPerPage(10);

            $pagerFactory = new PagerfantaFactory();

            return $pagerFactory->createRepresentation(
                $pager,
                new Hateoas\Configuration\Route('post_list', ['limit' => 10, 'page' => 1])
            );

            return $response->setData([
                'response' => json_decode($serializer->serialize($blog->getPosts(), self::SERIALIZATION_FORMAT, SerializationContext::create()->setGroups(self::SERIALIZATION_GROUPS))),
            ]);
        } else {
            $post = $postRepository->findOneBy([
                'blog' => $blog,
                'id' => $postId,
            ]);

            if (is_null($post)) { // This post does not exist or belong to this blog

                throw $this->createNotFoundException('This post does not exist');
            } else {
                return $response->setData([
                    'response' => json_decode($serializer->serialize($post, self::SERIALIZATION_FORMAT, SerializationContext::create()->setGroups(self::SERIALIZATION_GROUPS))),
                ]);
            }
        }
    }

    /**
     * @param string $permissions
     * @param Blog   $blog
     * @param string $comparison
     *
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    protected function checkAccess($permissions, Blog $blog, $comparison = 'AND')
    {
        $isGranted = true;

        if (false === is_array($permissions)) {
            $permissions = [$permissions];
        }

        foreach ($permissions as $permission) {
            $currentIsGranted = $this->get('security.authorization_checker')->isGranted($permission, $blog);
            if ('OR' === $comparison) {
                $isGranted = $isGranted || $currentIsGranted;
            } else {
                $isGranted = $isGranted && $currentIsGranted;
            }
        }

        if (false === $isGranted) {
            throw new AccessDeniedException();
        }

        $logEvent = new LogResourceReadEvent($blog->getResourceNode());
        $this->get('event_dispatcher')->dispatch('log', $logEvent);
    }
}
