<?php
declare(strict_types=1);

use App\Application\Actions\Auth\CreateAuthAction;
use App\Application\Actions\Auth\DeleteAuthAction;

use App\Application\Actions\Quadra\ListQuadrasAction;
use App\Application\Actions\Quadra\CreateQuadraAction;
use App\Application\Actions\Quadra\ListQuadraAgendaAction;
use App\Application\Actions\Quadra\ViewQuadraAction;

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\CreateUserAction;
use App\Application\Actions\User\EditUserAction;
use App\Application\Actions\User\ListUserAgendaAction;
use App\Application\Actions\User\CreateUserAgendaAction;
use App\Application\Actions\User\EditUserAgendaAction;
use App\Application\Actions\User\DeleteUserAgendaAction;
use App\Application\Actions\User\ViewUserAction;
use App\Application\Actions\User\DeleteUserAction;

use App\Application\Actions\Agenda\ListAgendasAction;
use App\Application\Actions\Agenda\ViewAgendaAction;

use App\Application\Middleware\TokenMiddleware;
use App\Application\Middleware\AdminOrOwnerOnlyMiddleware;
use App\Application\Middleware\AdminOnlyMiddleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    /*$app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });*/
    $app->group('/auth', function (Group $group) {
        $group->post('/login', CreateAuthAction::class);
        $group->delete('/logout/{token}', DeleteAuthAction::class)->add(TokenMiddleware::class);
    });

    $app->group('/usuarios', function (Group $group) {
        $group->get('', ListUsersAction::class)
            ->add(AdminOnlyMiddleware::class)
            ->add(TokenMiddleware::class);
        $group->post('', CreateUserAction::class);

        $group->put('/{id}', EditUserAction::class)
            ->add(AdminOrOwnerOnlyMiddleware::class)
            ->add(TokenMiddleware::class);
        $group->get('/{id}', ViewUserAction::class)
            ->add(AdminOrOwnerOnlyMiddleware::class)
            ->add(TokenMiddleware::class);
        $group->delete('/{id}', DeleteUserAction::class)
            ->add(AdminOrOwnerOnlyMiddleware::class)
            ->add(TokenMiddleware::class);

        $group->get('/{id}/agenda', ListUserAgendaAction::class)
            ->add(AdminOrOwnerOnlyMiddleware::class)
            ->add(TokenMiddleware::class);
        $group->post('/{id}/agenda', CreateUserAgendaAction::class)
            ->add(AdminOrOwnerOnlyMiddleware::class)
            ->add(TokenMiddleware::class);

        $group->put('/{id}/agenda/{agenda_id}', EditUserAgendaAction::class)
            ->add(AdminOrOwnerOnlyMiddleware::class)
            ->add(TokenMiddleware::class);
        $group->delete('/{id}/agenda/{agenda_id}', DeleteUserAgendaAction::class)
            ->add(AdminOrOwnerOnlyMiddleware::class)
            ->add(TokenMiddleware::class);
    });

    $app->group('/quadras', function (Group $group) {
        $group->get('', ListQuadrasAction::class);
        $group->post('', CreateQuadraAction::class)
            ->add(AdminOnlyMiddleware::class)
            ->add(TokenMiddleware::class);

        $group->get('/{id}', ViewQuadraAction::class);
        $group->delete('/{id}', DeleteQuadraAction::class)
            ->add(AdminOnlyMiddleware::class)
            ->add(TokenMiddleware::class);

        $group->get('/{id}/agenda', ListQuadraAgendaAction::class);
    });

    $app->group('/agendas', function (Group $group) {
        $group->get('', ListAgendasAction::class);
        $group->get('/{id}', ViewAgendaAction::class);
    });
};
