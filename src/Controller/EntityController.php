<?php

namespace Mia3\Expose\Controller;

use AppBundle\Repository\CompilationRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class EntityController extends Controller
{

    /**
     * @var EntityRepository
     */
    protected $repository;

    /**
     * @var string
     */
    protected $entityType;

    /**
     * Sets the container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;

        if ($this->entityType !== NULL) {
            $this->repository = $this->container->get('doctrine')->getManager()->getRepository($this->entityType);
        }
    }

    public function saveAndRedirectOnPost($request, $entityCallback, $redirectTarget) {
        if ($request->isMethod('POST')) {
            $entity = $entityCallback($request);
            try {
                $manager = $this->container->get('doctrine')->getManager();
                $manager->persist($entity);
                $manager->flush();
                $this->redirect($redirectTarget);
            } catch (ValidatorException $error) {
                return $error;
            }
        }
    }

//    /**
//     * @Route("index", name="entity.index")
//     */
//    public function indexAction(Request $request)
//    {
//        return $this->render(
//            $this->entityType . ':Index.html',
//            array(
//                'searches' => $this->repository->findAll()
//            )
//        );
//    }
//
//    /**
//     * @Route("entity/{id}", name="entity.show")
//     */
//    public function showAction($id, Request $request)
//    {
//        $entity = $this->repository->find($id);
//        return $this->render(
//            $this->entityType . ':Show.html',
//            array(
//                'entity' => $entity
//            )
//        );
//    }
//
//    /**
//     * @Route("entity/new", name="entity.new")
//     */
//    public function newAction(Request $request, $redirectTarget = '/index')
//    {
//        $entity = new $this->entityClassName();
//
//        if ($request->isMethod('POST')) {
//            $this->mapEntity($entity, $request);
//            try {
//                $manager = $this->container->get('doctrine')->getManager();
//                $manager->persist($entity);
//                $manager->flush();
//                return $this->redirect($redirectTarget);
//            } catch (ValidatorException $error) {
//                return $error;
//            }
//        }
//
//        return $this->render(
//            $this->entityType . ':Form.html',
//            array(
//                'entity' => $entity
//            )
//        );
//    }
//
//    /**
//     * @Route("entity/{id}/edit", name="entity.edit")
//     */
//    public function editAction($id, Request $request, $redirectTarget = '/index')
//    {
//        $entity = $this->repository->find($id);
//
//        if ($request->isMethod('POST')) {
//            $this->mapEntity($entity, $request);
//            try {
//                $manager = $this->container->get('doctrine')->getManager();
//                $manager->persist($entity);
//                $manager->flush();
//                return $this->redirect($redirectTarget);
//            } catch (ValidatorException $error) {
//                return $error;
//            }
//        }
//
//        return $this->render(
//            $this->entityType . ':Form.html',
//            array(
//                'entity' => $entity
//            )
//        );
//    }
//
//    /**
//     * @Route("entity/{id}/delete", name="entity.delete")
//     */
//    public function deleteAction($id, Request $request, $redirectTarget = '/index')
//    {
//        $entity = $this->repository->find($id);
//        $manager = $this->container->get('doctrine')->getManager();
//        $manager->remove($entity);
//        $manager->flush();
//        return $this->redirect($redirectTarget);
//    }
}
