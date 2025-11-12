<?php

namespace App\Http\Controllers;

use App\Actions\Canonical;
use App\Actions\GenerateBreadcrumbMicro;
use App\Actions\GenerateItemsForBreadcrumb;
use App\Actions\GenerateMicroDataForCatalog;
use App\Actions\GenerateServiceMicro;
use App\Models\Filter;
use App\Models\Link;
use App\Models\Metro;
use App\Models\MetroNear;
use App\Repository\FilterRepository;
use App\Repository\LinkRepository;
use App\Repository\MetaRepository;
use App\Repository\TextRepository;
use Illuminate\Filesystem\Cache;
use Illuminate\Http\Request;

class FilterController extends Controller
{

    private GenerateBreadcrumbMicro $breadMicro;
    private GenerateMicroDataForCatalog $microData;
    private LinkRepository $linkRepository;
    private FilterRepository $filterRepository;

    public function __construct()
    {
        $this->breadMicro = new GenerateBreadcrumbMicro();
        $this->microData = new GenerateMicroDataForCatalog();
        $this->linkRepository = new LinkRepository();
        $this->filterRepository = new FilterRepository();

        parent::__construct();
    }

    public function __invoke($city, $search, MetaRepository $metaRepository, Request $request)
    {

        $cityInfo = $this->cityRepository->getCity($city);
        $posts = $this->postRepository->getForFilterCatalog($cityInfo['id'], $search);
        $data = $this->dataRepository->getData($cityInfo['id']);

        $text = (new TextRepository())->getText($cityInfo['id'], $request->getRequestUri(), $request);

        $path = (new Canonical())->get($request->getRequestUri());

        $filterParams = $this->filterRepository->getData($search);

        $meta = $metaRepository->getForFilter($search, $cityInfo, $filterParams);

        $breadMicro = $this->breadMicro->generate($request, $meta['h1']);

        $productMicro = false;

        $serviceMicro = (new GenerateServiceMicro())->generate($_SERVER['HTTP_HOST'], $meta, $cityInfo);

        if ($posts) $productMicro = $this->microData->generate($meta['title'], $posts, $search, $cityInfo['id']);

        if (isset($filterParams[0]->short_name) and $filterParams[0]->short_name == 'metro'){

            $data['current_metro'] = Metro::where(['id' => $filterParams[0]->related_id ])->first();
            $data['near_metro'] = MetroNear::where(['metro_id' => $filterParams[0]->related_id ])
                ->with('metro')
                ->get();

        }

        $sort = $this->sort;

        $links = $this->linkRepository->getLink($search, $filterParams);

        return view('new.filter.index',
            compact('posts', 'data', 'meta', 'path', 'breadMicro', 'productMicro',
                'links', 'serviceMicro', 'text', 'sort')
        );
    }

    public function slug($city, $section, $slug,  MetaRepository $metaRepository, Request $request)
    {

        $cityInfo = $this->cityRepository->getCity($city);
        $posts = $this->postRepository->getForFilterCatalog($cityInfo['id'], $slug);
        $data = $this->dataRepository->getData($cityInfo['id']);

        $text = (new TextRepository())->getText($cityInfo['id'], $request->getRequestUri(), $request);

        $path = (new Canonical())->get($request->getRequestUri());

        $filterParams = $this->filterRepository->getData($slug);

        $meta = $metaRepository->getForFilter($slug, $cityInfo, $filterParams);

        $breadCrumbItems = (new GenerateItemsForBreadcrumb())->generate($request, $meta['h1']);

        $breadMicro = $this->breadMicro->generateFromArray($request, $breadCrumbItems);

        $productMicro = false;

        $serviceMicro = (new GenerateServiceMicro())->generate($_SERVER['HTTP_HOST'], $meta, $cityInfo);

        if ($posts) $productMicro = $this->microData->generate($meta['title'], $posts, $slug, $cityInfo['id']);

        if (isset($filterParams[0]->short_name) and $filterParams[0]->short_name == 'metro'){

            $data['current_metro'] = Metro::where(['id' => $filterParams[0]->related_id ])->first();
            $data['near_metro'] = MetroNear::where(['metro_id' => $filterParams[0]->related_id ])
                ->with('metro')
                ->get();

        }

        $sort = $this->sort;

        $links = $this->linkRepository->getLink($section, $filterParams);

        return view('new.filter.index',
            compact('posts', 'data', 'meta', 'path', 'breadMicro', 'productMicro',
                'links', 'serviceMicro', 'text', 'sort', 'breadCrumbItems')
        );
    }

    public function more($city, $search)
    {

        $cityInfo = $this->cityRepository->getCity($city);

        $posts = $this->postRepository->getForFilterCatalog($cityInfo['id'], $search);

        $data['posts'] = view(PATH.'.include.more', compact('posts', 'cityInfo'))->render();
        $data['next_page'] = str_replace('http', 'https', $posts->nextPageUrl());

        return json_encode($data);
    }

}
