<?php

namespace App\Http\Controllers;

use App\Models\Post;

class SiteMapController extends Controller
{
    public function __invoke($city)
    {
        $cityInfo = $this->cityRepository->getCity($city);
        $data = $this->dataRepository->getData($cityInfo['id']);

        $posts = Post::where('city_id', $cityInfo['id'])->get();

        return response()->view(PATH.'.map.index', compact('data', 'posts'))
            ->header('content-type', 'text/xml;charset=UTF-8');
    }

    public function post($city)
    {
        $cityInfo = $this->cityRepository->getCity($city);

        $posts = Post::where('city_id', $cityInfo['id'])
            ->with('national')
            ->get();

        return response()->view(PATH.'.map.post', compact('posts'))
            ->header('content-type', 'text/xml;charset=UTF-8');

    }

    public function page($city)
    {
        $cityInfo = $this->cityRepository->getCity($city);

        $data = $this->dataRepository->getData($cityInfo['id']);

        return response()->view(PATH.'.map.page', compact('data'))
            ->header('content-type', 'text/xml;charset=UTF-8');

    }

}
