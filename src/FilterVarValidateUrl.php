<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */
declare(strict_types=1);

namespace pvc\filtervar;

/**
 * Class FilterVarValidateUrl
 *
 * Since php 8.0, requiring scheme (e.g. the protocol, the "http" part of http://www.somewhere.com) and requiring
 * hostname ("www.somewhere.com") have been removed because scheme and hostname have always been required.  It is
 * possible to configure web servers so that if the scheme is missing, the server will assume a scheme (usually http).
 *
 * If you look at the documentation for FILTER_VALIDATE_URL, you will see a flag called FILTER_NULL_ON_FAILURE, which
 * is meant to tell filter_var to return null instead of false.  This class does not support that - the validate method
 * returns a pure boolean.
 */
class FilterVarValidateUrl extends FilterVarValidate
{
    /**
     * @throws err\InvalidFilterException
     */
    public function __construct()
    {
        parent::__construct(FILTER_VALIDATE_URL);
        $this->setLabel('url');
    }

    /**
     * requirePath
     */
    public function requirePath(): void
    {
        $this->addFlag(FILTER_FLAG_PATH_REQUIRED);
    }

    /**
     * isPathRequired
     * @return bool
     */
    public function isPathRequired(): bool
    {
        return in_array(FILTER_FLAG_PATH_REQUIRED, $this->getFlags());
    }

    /**
     * requireQuery
     */
    public function requireQuery(): void
    {
        $this->addFlag(FILTER_FLAG_QUERY_REQUIRED);
    }

    /**
     * isQueryRequired
     * @return bool
     */
    public function isQueryRequired(): bool
    {
        return in_array(FILTER_FLAG_QUERY_REQUIRED, $this->getFlags());
    }
}