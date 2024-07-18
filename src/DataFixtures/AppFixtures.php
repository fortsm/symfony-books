<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Publisher;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $publisher1 = new Publisher();
        $publisher1->setName('Эксмо');
        $publisher1->setAddress('Москва, Ул. Зорге, д.1, стр.1');
        $manager->persist($publisher1);

        $publisher2 = new Publisher();
        $publisher2->setName('Альпина Паблишер');
        $publisher2->setAddress('Москва, 4-я Магистральная улица, дом 5, строение 1');
        $manager->persist($publisher2);

        $publisher3 = new Publisher();
        $publisher3->setName('Манн Иванов и Фербер');
        $publisher3->setAddress('Москва, Б. Козихинский пер., д.7, стр.2, оф. 24');
        $manager->persist($publisher3);

        $author1 = new Author();
        $author1->setFirstname('Сергей');
        $author1->setLastname('Есенин');
        $manager->persist($author1);

        $author2 = new Author();
        $author2->setFirstname('Марина');
        $author2->setLastname('Цветаева');
        $manager->persist($author2);

        $author3 = new Author();
        $author3->setFirstname('Александр');
        $author3->setLastname('Блок');
        $manager->persist($author3);

        $book1 = new Book();
        $book1->setName('Сборник сочинений');
        $book1->setYear(2003);
        $book1->setPublisher($publisher1);
        $book1->addAuthor($author1);
        $book1->addAuthor($author3);
        $manager->persist($book1);

        $book2 = new Book();
        $book2->setName('Стихи и проза');
        $book2->setYear(2014);
        $book2->setPublisher($publisher2);
        $book2->addAuthor($author2);
        $book2->addAuthor($author3);
        $manager->persist($book2);

        $book3 = new Book();
        $book3->setName('Роман о любви');
        $book3->setYear(2021);
        $book3->setPublisher($publisher3);
        $book3->addAuthor($author1);
        $book3->addAuthor($author2);
        $manager->persist($book3);

        $manager->flush();
    }
}
