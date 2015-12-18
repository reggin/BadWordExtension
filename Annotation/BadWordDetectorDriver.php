<?php

namespace RenowazeBundle\Annotation;

use Doctrine\Common\Annotations\Reader;
use Doctrine\ORM\Event\LifecycleEventArgs;
use RenowazeBundle\Entity\BadWordDetectorInterface;
use RenowazeBundle\Entity\BadWord;

class BadWordDetectorDriver
{

    /**
     * @var Reader
     */
    private $reader;

    /**
     * @param Reader $reader
     */
    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    /**
     * @param LifecycleEventArgs $args
     * @return bool
     * @throws \Exception
     */
    public function PrePersist(LifecycleEventArgs $args)
    {
        return $this->checkBadWords($args);
    }

    /**
     * @param LifecycleEventArgs $args
     * @return bool
     * @throws \Exception
     */
    public function PreUpdate(LifecycleEventArgs $args)
    {
        return $this->checkBadWords($args);
    }

    /**
     * @param LifecycleEventArgs $args
     * @return bool
     * @throws \Exception
     */
    public function checkBadWords(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof BadWordDetectorInterface) {
            return true;
        }

        $badWords = $args->getEntityManager()->getRepository('RenowazeBundle:BadWord')->findAll();

        /** @var BadWordDetector $annotationParams */
        $annotationParams = $this->reader->getClassAnnotation(new \ReflectionClass($entity), 'RenowazeBundle\Annotation\BadWordDetector');

        foreach ($annotationParams->fields as $field) {
            $methodName = 'get' . ucfirst($field);
            if (!method_exists($entity, $methodName)) {
                throw new \Exception(sprintf('Field "%s" not found in entity "%s"', $methodName, get_class($entity)));
            }

            /** @var BadWord $badWord */
            foreach ($badWords as $badWord) {
                if (strpos($entity->$methodName(), $badWord->getWord()) !== false) {
                    $entity->setHasBadWords(true);

                    return true;
                }
            }
        }

        $entity->setHasBadWords(false);

        return true;
    }
}