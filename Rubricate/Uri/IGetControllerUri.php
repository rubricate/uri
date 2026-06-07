<?php 

declare(strict_types=1);

namespace Rubricate\Uri;

interface IGetControllerUri
{
    public function getController(): string;
}

