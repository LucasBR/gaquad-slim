<?php
declare(strict_types=1);

use App\Domain\Auth\AuthRepository;
//use App\Infrastructure\Persistence\Auth\InMemoryAuthRepository;
use App\Infrastructure\Persistence\Auth\SQLiteAuthRepository;

use App\Domain\User\UserRepository;
//use App\Infrastructure\Persistence\User\InMemoryUserRepository;
use App\Infrastructure\Persistence\User\SQLiteUserRepository;

use App\Domain\Quadra\QuadraRepository;
//use App\Infrastructure\Persistence\Quadra\InMemoryQuadraRepository;
use App\Infrastructure\Persistence\Quadra\SQLiteQuadraRepository;

use App\Domain\Agenda\AgendaRepository;
//use App\Infrastructure\Persistence\Agenda\InMemoryAgendaRepository;
use App\Infrastructure\Persistence\Agenda\SQLiteAgendaRepository;

use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    // Here we map our UserRepository interface to its in memory implementation
    /*$containerBuilder->addDefinitions([
        AuthRepository::class => \DI\autowire(InMemoryAuthRepository::class),
        UserRepository::class => \DI\autowire(InMemoryUserRepository::class),
        QuadraRepository::class => \DI\autowire(InMemoryQuadraRepository::class),
        AgendaRepository::class => \DI\autowire(InMemoryAgendaRepository::class),
    ]);*/

    $containerBuilder->addDefinitions([
        AuthRepository::class => \DI\autowire(SQLiteAuthRepository::class),
        UserRepository::class => \DI\autowire(SQLiteUserRepository::class),
        QuadraRepository::class => \DI\autowire(SQLiteQuadraRepository::class),
        AgendaRepository::class => \DI\autowire(SQLiteAgendaRepository::class),
    ]);

};
