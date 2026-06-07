<?php 

declare(strict_types=1);

namespace Rubricate\Uri;

interface IGetNamespaceAndControllerUri
{
    public function getNamespaceAndController(): string;
}

