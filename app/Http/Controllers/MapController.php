<?php

namespace App\Http\Controllers;

use App\Actions\GenerateBreadcrumbMicro;
use App\Actions\GenerateMicroDataForCatalog;
use App\Repository\MetaRepository;
use Illuminate\Http\Request;

class MapController extends Controller
{

    private GenerateBreadcrumbMicro $breadMicro;

    public function __construct()
    {
        $this->breadMicro = new GenerateBreadcrumbMicro();

        parent::__construct();
    }

    public function __invoke($city, MetaRepository $metaRepository, Request $request)
    {

        $cityInfo = $this->cityRepository->getCity($city);
        $data = $this->dataRepository->getData($cityInfo['id']);

        $posts = $this->postRepository->getForMap($cityInfo['id']);

        $meta = $metaRepository->getForFilter('intim-map', $cityInfo, $request);

        $breadMicro = $this->breadMicro->generate($request, $meta['h1']);

        return view(  'new.map.map', compact(
            'posts', 'data', 'meta', 'breadMicro'
        ));
    }
}
