<?php

namespace Database\Seeders;

use App\Models\Couleur;
use App\Models\Marque;
use App\Models\Mode;
use App\Models\ModeType;
use App\Models\Order;
use App\Models\Pays;
use App\Models\Province;
use App\Models\Role;
use App\Models\Taille;
use App\Models\Type;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        Province::insert([
            ['nom'=>'KWANGO', 'code'=>NULL, 'superficie'=>NULL,'pays_id'=>1],
            ['nom'=>'KWILU', 'code'=>NULL, 'superficie'=>NULL,'pays_id'=>1],
            ['nom'=>'MAI-NDOMBE', 'code'=>NULL, 'superficie'=>NULL,'pays_id'=>1],
            ['nom'=>'KONGO-CENTRAL', 'code'=>NULL, 'superficie'=>NULL,'pays_id'=>1],
            ['nom'=>'EQUATEUR', 'code'=>NULL, 'superficie'=>NULL,'pays_id'=>1],
            ['nom'=>'MONGALA', 'code'=>NULL, 'superficie'=>NULL,'pays_id'=>1],
            ['nom'=>'NORD-UBANGI', 'code'=>NULL, 'superficie'=>NULL,'pays_id'=>1],
            ['nom'=>'SUD-UBANGI', 'code'=>NULL, 'superficie'=>NULL,'pays_id'=>1],
            ['nom'=>'TSHUAPA', 'code'=>NULL, 'superficie'=>NULL,'pays_id'=>1],
            ['nom'=>'KASAI', 'code'=>NULL, 'superficie'=>NULL,'pays_id'=>1],
            ['nom'=>'KAISAI-CENTRAL', 'code'=>NULL, 'superficie'=>NULL,'pays_id'=>1],
            ['nom'=>'KASAI-ORIENTAL', 'code'=>NULL, 'superficie'=>NULL,'pays_id'=>1],
            ['nom'=>'LOMAMI', 'code'=>NULL, 'superficie'=>NULL,'pays_id'=>1],
            ['nom'=>'SANKURU', 'code'=>NULL, 'superficie'=>NULL,'pays_id'=>1],
            ['nom'=>'HAUT-KATANGA', 'code'=>NULL, 'superficie'=>NULL,'pays_id'=>1],
            ['nom'=>'HAUT-LOMAMI', 'code'=>NULL, 'superficie'=>NULL,'pays_id'=>1],
            ['nom'=>'LUALABA', 'code'=>NULL, 'superficie'=>NULL,'pays_id'=>1],
            ['nom'=>'TANGANYIKA', 'code'=>NULL, 'superficie'=>NULL,'pays_id'=>1],
            ['nom'=>'NORD-KIVU', 'code'=>NULL, 'superficie'=>NULL,'pays_id'=>1],
            ['nom'=>'MANIEMA', 'code'=>NULL, 'superficie'=>NULL,'pays_id'=>1],
            ['nom'=>'BAS-UELE', 'code'=>NULL, 'superficie'=>NULL,'pays_id'=>1],
            ['nom'=>'HAUT-UELE', 'code'=>NULL, 'superficie'=>NULL,'pays_id'=>1],
            ['nom'=>'ITURI', 'code'=>NULL, 'superficie'=>NULL,'pays_id'=>1],
            ['nom'=>'TSHOPO', 'code'=>NULL, 'superficie'=>NULL,'pays_id'=>1],
            ['nom'=>'SUD-KIVU', 'code'=>NULL, 'superficie'=>NULL,'pays_id'=>1],
            ['nom'=>'KINSHASA', 'code'=>NULL, 'superficie'=>NULL,'pays_id'=>1],
        ]);

        Pays::insert([
            ['nom'=>'REPUBLIQUE DEMOCRATIQUE DU CONGO', 'superficie'=>NULL],
            ['nom'=>'ANGOLA', 'superficie'=>NULL],
            ['nom'=>'RWANDA','superficie'=>NULL]
        ]);

        Mode::insert([
            ['mode'=>'Homme'],
            ['mode'=>'Femme'],
            ['mode'=>'Garçon'],
            ['mode'=>'Fille'],
            ['mode'=>'Mixte'],
        ]);

        Taille::insert([
            ['taille'=>'XS','description'=>'Extra short'],
            ['taille'=>'S','description'=>'Short'],
            ['taille'=>'M','description'=>'Medium'],
            ['taille'=>'L','description'=>'Large'],
            ['taille'=>'XL','description'=>'Extra large'],
            ['taille'=>'XXL','description'=>'Double extra large'],
            ['taille'=>'3XL','description'=>'Triple extra large']
        ]);

        Type::insert([
            ['type'=>'Vêtement'],
            ['type'=>'Alimentaire'],
            ['type'=>'Soin & beauté'],
            ['type'=>'Electro'],
            ['type'=>'Meuble'],
            ['type'=>'Portable'],
            ['type'=>'Cuisine'],
            ['type'=>'Jouet']
        ]);

        Role::insert([
            ['role'=>'admin'],
            ['role'=>'manager'],
            ['role'=>'marchand']
        ]);

        Couleur::insert([
            ['couleur'=>'rouge','color'=>'red'],
            ['couleur'=>'noire','color'=>'black'],
            ['couleur'=>'blanche','color'=>'white'],
            ['couleur'=>'verte','color'=>'green'],
            ['couleur'=>'orange','color'=>'orange'],
            ['couleur'=>'bleue','color'=>'blue'],
            ['couleur'=>'gris','color'=>'gray'],
            ['couleur'=>'rose','color'=>'pink'],
            ['couleur'=>'jaune','color'=>'yellow'],
            ['couleur'=>'bleue ciel','color'=>'skyblue'],
            ['couleur'=>'rouge foncée','color'=>'darkred'],
            ['couleur'=>'verte foncée','color'=>'darkgreen'],
            ['couleur'=>'bleue foncée','color'=>'darkblue'],
        ]);
    }
}
