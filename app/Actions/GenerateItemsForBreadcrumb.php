<?php

namespace App\Actions;

class GenerateItemsForBreadcrumb
{
    public function generate($request, $name)
    {
        $sections = [
            'metro'     => 'Метро',
            'rayon'     => 'Район',
            'national'  => 'Национальность',
            'service'   => 'Услуги',
        ];

        $url = $request->path();

        $urlItems = explode('/', $url);

        $result = array( $urlItems[0] => $sections[$urlItems[0]], $request->path() =>  $name);

        return $result;

    }
}
