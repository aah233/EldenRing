<?php

namespace App\Http\Controllers;

use Goutte\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NewsController extends Controller
{

    public function fetchNews()
    {
        $client = new Client();
        $crawler = $client->request('GET', 'https://es.bandainamcoent.eu/elden-ring/elden-ring');

        $news = $crawler->filter('.views-row')->each(function ($node) {
            // Verificar si existen los selectores antes de intentar acceder a ellos
            $titleNode = $node->filter('.news__infos-title');
            $linkNode = $node->filter('.news__infos-link');

            if ($titleNode->count() > 0 && $linkNode->count() > 0) {
                return [
                    'title' => $titleNode->text(),
                    'link' => $linkNode->attr('href'),
                ];
            }
            return null; // Retornar null si no se encuentran los nodos
        });

        // Filtrar los valores nulos del resultado
        $news = array_filter($news);

        return response()->json($news);
    }
}
