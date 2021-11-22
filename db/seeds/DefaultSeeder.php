<?php

use Phinx\Seed\AbstractSeed;

class DefaultSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run()
    {
        $this->table('product')
            ->insert([
                [
                    'name' => '13palcový MacBook Pro',
                    'description' => '13palcový MacBook Pro má díky čipu Apple M1 neuvěřitelnou rychlost a výkon. Až 2,8× výkonnější CPU. Až 5× rychlejší grafiku. Náš nejvyspělejší Neural Engine, který umožňuje až 11× rychlejší strojové učení. A výdrž baterie až 20 hodin – nejvíc ze všech Maců. Je to náš nejoblíbenější profesionální notebook, ovšem na úplně nové úrovni.',
                    'price' => 3899000,
                    'slug' => 'macbook-pro'
                ],
                [
                    'name' => '27palcový iMac',
                    'description' => '27palcový iMac je nabitý špičkovými nástroji a aplikacemi, které ti pomůžou posunout každý nápad o pořádný kus dál. Jeho superrychlý procesor a grafika, ohromná paměť a čistě flashové úložiště s přehledem zvládnou jakékoli pracovní vytížení. A díky vyspělé audio a video výbavě a fantastickému Retina 5K displeji na něm všechno získává velkolepé obrysy.',
                    'price' => 5499000,
                    'slug' => 'imac'
                ]
            ])
            ->saveData();
    }
}
