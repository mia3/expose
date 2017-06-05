<?php
namespace Mia3\Expose\Action\Index;

use Doctrine\ORM\EntityRepository;
use Mia3\Expose\Core\Expose;
use Mia3\Expose\Request\RequestInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\PropertyAccess\PropertyAccess;

class DoctrineEntityIndex
{
    use ContainerAwareTrait;

    /**
     * @var string
     */
    protected $className;

    /**
     * @var ClassSchema
     */
    protected $classSchema;

    /**
     * @var EntityRepository
     */
    protected $repository;

    /**
     * @var array
     */
    protected $itemProperties = array();

    /**
     * @var array
     */
    protected $globalActions = array();

    /**
     * @var array
     */
    protected $itemActions = array();

    /**
     * @var RequestInterface
     */
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function setClassName($className)
    {
        $this->className = $className;
        $this->classSchema = Expose::classSchemaFactory()->createClassSchema($className);
//        $this->repository = $this->container->get('doctrine')->getManager()->getRepository($className);
    }

    /**
     * @param EntityRepository $repository
     */
    public function setRepository($repository)
    {
        $this->repository = $repository;
    }

    public function getItems()
    {
        $accessor = PropertyAccess::createPropertyAccessor();
        $objects = $this->repository->findAll();
        $items = [];
        foreach ($objects as $object) {
            $item = new Item();
            $item->setValue($object);
            $properties = array();
            foreach ($this->itemProperties as $itemProperty => $itemPropertyLabel) {
                $properties[$itemProperty] = $accessor->getValue($object, $itemProperty);
            }
            $item->setProperties($properties);
            $items[] = $item;
        }

        return $items;
    }

    /**
     * @return array
     */
    public function getItemProperties()
    {
        return $this->itemProperties;
    }

    /**
     * @param array $itemProperties
     */
    public function setItemProperties($itemProperties)
    {
        $this->itemProperties = $itemProperties;
    }

    /**
     * @return array
     */
    public function getGlobalActions()
    {
        return $this->globalActions;
    }

    /**
     * @param array $globalActions
     */
    public function setGlobalActions($globalActions)
    {
        $this->globalActions = $globalActions;
    }

    /**
     * @param string $globalAction
     */
    public function addGlobalAction($globalAction)
    {
        $this->globalActions[] = $globalAction;
    }

    /**
     * @return array
     */
    public function getItemActions()
    {
        return $this->itemActions;
    }

    /**
     * @param array $itemActions
     */
    public function setItemActions($itemActions)
    {
        $this->itemActions = $itemActions;
    }

    public function addItemAction($itemAction)
    {
        $this->itemActions[] = $itemAction;
    }
}