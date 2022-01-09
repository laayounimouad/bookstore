<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Genre;
use App\Entity\Auteur;
use App\Entity\Livre;
use App\Entity\User;
use Faker\Factory;
class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $this->faker = Factory::create();
        
        // $product = new Product();
        for ($i = 1; $i <= 10; $i++) {
            $genre = new Genre();
            $genre->setNom('Genre Type '.$i);
            $this->addReference('genre_'.$i,$genre);
            $manager->persist($genre);
        }
        for ($i = 1; $i <= 20; $i++) {
            $auteur = new Auteur();
            $gender = $this->faker->randomElement($array = array ('male','female'));
            $auteur->setNomPrenom($this->faker->name($gender));
            if($gender=='male') $auteur->setSexe('M');
            if($gender=='female') $auteur->setSexe('F');
            $auteur->setDateDeNaissance($this->faker->dateTimeBetween($format = 'Y-m-d', $max = '2004-01-01'));
            $auteur->setNationalite($this->faker->country);
            $this->addReference('auteur_'.$i,$auteur);
            $manager->persist($auteur);
        }
        for ($i = 1; $i <= 50; $i++) {
            $livre = new Livre();
            for($j=1;$j<=$this->faker->numberBetween(1,3);$j++){
                $livre->addAuteur($this->getReference('auteur_'.$this->faker->numberBetween(1,20)));
            }
            for($j=1;$j<=$this->faker->numberBetween(1,3);$j++){
                $livre->addGenre($this->getReference('genre_'.$this->faker->numberBetween(1,10)));
            }
            $livre->setIsdn($this->faker->ean13());
            $livre->setTitre($this->faker->sentence);
            $livre->setNombrePages($this->faker->randomNumber);
            $livre->setDateDeParution($this->faker->dateTimeBetween($startDate = '-101 years', $endDate = 'now'));
            $livre->setNote($this->faker->numberBetween($min = 0, $max = 10));
            $manager->persist($livre);
        }
        // $u = new User();
        // $u->setRole("ROLE_ADMIN");
        // $u->setLogin($this->faker->userName );
        // $u->setPassword($this->faker->password );
        // $manager->persist($u);
        // $manager->persist($product);$this->faker->text

        $manager->flush();
    }
}