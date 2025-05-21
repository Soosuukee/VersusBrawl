<?php

namespace App\Traits;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;

trait EntityValidationTrait
{
    protected ValidatorInterface $validator;

    public function setValidator(ValidatorInterface $validator): void
    {
        $this->validator = $validator;
    }

    protected function validateOrFail(object $entity): void
    {
        $violations = $this->validator->validate($entity);

        if (count($violations) > 0) {
            foreach ($violations as $violation) {
                echo '❌ ' . $violation->getPropertyPath() . ': ' . $violation->getMessage() . PHP_EOL;
            }

            throw new \RuntimeException(get_class($entity) . ' invalide, fixture bloquée.');
        }
    }
}
