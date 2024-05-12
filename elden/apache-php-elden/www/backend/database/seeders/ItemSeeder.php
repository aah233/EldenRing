<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $client = new Client();
        try {
            // Realiza la solicitud a la API
            $response = $client->request('GET', 'https://eldenring.fanapis.com/api/items?limit=462');
            $items = json_decode($response->getBody()->getContents(), true);

            // Verifica si la respuesta contiene 'data'
            if (isset($items['data'])) {
                foreach ($items['data'] as $item) {
                    // Inserta cada ítem en la base de datos
                    Item::create([
                        'id'           => $item['id'],
                        'name'         => $item['name'],
                        'image'        => $item['image'] ?? null, // Asume que estos campos pueden ser opcionales
                        'description'  => $item['description'] ?? null,
                        'type'         => $item['type'] ?? null,
                        'effect'       => $item['effect'] ?? null,
                    ]);
                }
            }
        } catch (RequestException $e) {
            // Maneja el error de solicitud
            echo "Error al realizar la solicitud: " . $e->getMessage();
        }
    }
}
