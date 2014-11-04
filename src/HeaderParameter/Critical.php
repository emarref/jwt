<?php

namespace Emarref\Jwt\HeaderParameter;

use Emarref\Jwt\Claim;

/**
 * "crit" (Critical) Header Parameter
 *
 * The "crit" (critical) Header Parameter indicates that extensions to the initial RFC versions of
 * [[ this specification ]] and [JWA] are being used that MUST be understood and processed.  Its value is an array
 * listing the Header Parameter names present in the JOSE Header that use those extensions.  If any of the listed
 * extension Header Parameters are not understood and supported by the recipient, it MUST reject the JWS.  Producers
 * MUST NOT include Header Parameter names defined by the initial RFC versions of [[ this specification ]] or [JWA] for
 * use with JWS, duplicate names, or names that do not occur as Header Parameter names within the JOSE Header in the
 * "crit" list. Producers MUST NOT use the empty list "[]" as the "crit" value. Recipients MAY reject the JWS if the
 * critical list contains any Header Parameter names defined by the initial RFC versions of [[ this specification ]] or
 * [JWA] for use with JWS, or any other constraints on its use are violated.  When used, this Header Parameter MUST be
 * integrity protected; therefore, it MUST occur only within the JWS Protected Header.  Use of this Header Parameter is
 * OPTIONAL.  This Header Parameter MUST be understood and processed by implementations.
 *
 * An example use, along with a hypothetical "exp" (expiration-time) field is:
 *
 * {"alg":"ES256",
 *  "crit":["exp"],
 *  "exp":1363284000
 * }
 */
class Critical extends AbstractParameter
{
    const NAME = 'crit';

    /**
     * @param array $value
     */
    public function __construct(array $value = [])
    {
        parent::__construct($value);
    }

    /**
     * @param array $value
     */
    public function setValue($value)
    {
        if (!is_array($value)) {
            $value = [$value];
        }

        parent::setValue($value);
    }

    /**
     * @param ParameterInterface $parameter
     */
    public function addParameter(ParameterInterface $parameter)
    {
        $value = $this->getValue();

        if (!in_array($parameter->getName(), $value)) {
            $value[] = $parameter->getName();
            $this->setValue($value);
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }
}
