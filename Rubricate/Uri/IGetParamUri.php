<?php 

declare(strict_types=1);

namespace Rubricate\Uri;

interface IGetParamUri
{
    public function getParam(int $num): ?string;
}

