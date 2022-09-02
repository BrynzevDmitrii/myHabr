<?php 
namespace Ltreu\MyHabr\Blog\Container;

use ReflectionClass;
use Psr\Container\ContainerInterface;
use Ltreu\MyHabr\Exceptions\NotFoundException;


class DIContainer implements ContainerInterface
{
    
    private array $resolvers = [];


    public function bind(string $type, $resolver)
    {
        $this->resolvers[$type] = $resolver;
    }

    /**
     * @throws NotFoundException
     */
    public function get(string $type): object
    {

        if (array_key_exists($type, $this->resolvers)) {

            $typeToCreate = $this->resolvers[$type];


            if (is_object($typeToCreate)) {
                return $typeToCreate;
            }


            return $this->get($typeToCreate);
        }
        if (!class_exists($type)) {
            throw new NotFoundException("Cannot resolve type: $type");
        }
        $reflectionClass = new ReflectionClass($type);

        $constructor = $reflectionClass->getConstructor();

        if (null === $constructor) {
            return new $type();
        }
        $parameters = [];

        foreach ($constructor->getParameters() as $parameter) {
            $parameterType = $parameter->getType()->getName();
            $parameters[] = $this->get($parameterType);
        }
        return new $type(...$parameters);
    }

    public function has(string $id): bool
    {
        try {
            $this->get($id);
        } catch (NotFoundException $e) {

            return false;
        }

        return true;
    }
}