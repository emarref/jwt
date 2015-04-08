<?php

namespace Emarref\Jwt\Encryption;

use Emarref\Jwt\Algorithm;

class Factory
{
    /**
     * @param Algorithm\AlgorithmInterface $algorithm
     * @return Asymmetric|Symmetric
     */
    static public function create(Algorithm\AlgorithmInterface $algorithm)
    {
        if ($algorithm instanceof Algorithm\AsymmetricInterface) {
            $encryption = new Asymmetric($algorithm);
        } elseif ($algorithm instanceof Algorithm\SymmetricInterface) {
            $encryption = new Symmetric($algorithm);
        } else {
            throw new \InvalidArgumentException(sprintf(
                'Algorithm of class "%s" is neither symmetric or asymmetric.',
                get_class($algorithm)
            ));
        }

        return $encryption;
    }
}
