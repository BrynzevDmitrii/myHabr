<?php
namespace Ltreu\MyHabr\HTTP\Auth;

use Ltreu\MyHabr\Blog\UUID;
use Ltreu\MyHabr\HTTP\Request;
use Ltreu\MyHabr\Persons\User;
use Psr\Log\InvalidArgumentException;
use Ltreu\MyHabr\Exceptions\AuthException;
use Ltreu\MyHabr\Exceptions\HttpException;
use Ltreu\MyHabr\Exceptions\UserNotFoundException;
use Ltreu\MyHabr\HTTP\Auth\IdentificationInterface;

class UuidIdentification implements IdentificationInterface
{
public function __construct(
private UsersRepositoryInterface $usersRepository
) {
}
public function user(Request $request): User
{
    try {
    // Получаем UUID пользователя из JSON-тела запроса;
    // ожидаем, что корректный UUID находится в поле user_uuid
    $userUuid = new UUID($request->jsonBodyField('user_uuid'));
    } catch (HttpException|InvalidArgumentException $e) {
    // Если невозможно получить UUID из запроса -
    // бросаем исключение
    throw new AuthException($e->getMessage());
    }
    try {
    // Ищем пользователя в репозитории и возвращаем его
    return $this->usersRepository->get($userUuid);
    } catch (UserNotFoundException $e) {
    // Если пользователь с таким UUID не найден -
    // бросаем исключение
    throw new AuthException($e->getMessage());
    }
}
}

