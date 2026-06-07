<?php 

declare(strict_types=1);

namespace Rubricate\Uri;

interface IUri extends 

    IGetControllerUri,
    IGetActionUri,
    IGetParamUri,
    IGetParamArrUri,
    IGetStrUri,
    IGetArrUri
{

}

