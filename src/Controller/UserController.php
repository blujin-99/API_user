<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/users')]
class UserController extends AbstractController
{
    public function __construct(private readonly UserRepository $userRepository) {}

    #[Route('', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $users = array_map(fn($u) => $u->toArray(), $this->userRepository->findAll());
        return $this->json($users);
    }

    #[Route('', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true) ?? [];

        $required = ['nombre', 'apellido', 'correo', 'contrasena'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                return $this->json(['error' => "El campo '$field' es requerido."], Response::HTTP_BAD_REQUEST);
            }
        }

        if (!filter_var($data['correo'], FILTER_VALIDATE_EMAIL)) {
            return $this->json(['error' => 'El correo no es válido.'], Response::HTTP_BAD_REQUEST);
        }

        if ($this->userRepository->findByCorreo($data['correo']) !== null) {
            return $this->json(['error' => 'El correo ya está registrado.'], Response::HTTP_CONFLICT);
        }

        $user = $this->userRepository->create(
            $data['nombre'],
            $data['apellido'],
            $data['correo'],
            $data['contrasena'],
        );

        return $this->json($user->toArray(), Response::HTTP_CREATED);
    }

    #[Route('/{id}', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        $user = $this->userRepository->find($id);
        if ($user === null) {
            return $this->json(['error' => 'Usuario no encontrado.'], Response::HTTP_NOT_FOUND);
        }
        return $this->json($user->toArray());
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function update(int $id, Request $request): JsonResponse
    {
        $user = $this->userRepository->find($id);
        if ($user === null) {
            return $this->json(['error' => 'Usuario no encontrado.'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true) ?? [];

        if (isset($data['correo'])) {
            if (!filter_var($data['correo'], FILTER_VALIDATE_EMAIL)) {
                return $this->json(['error' => 'El correo no es válido.'], Response::HTTP_BAD_REQUEST);
            }
            $existing = $this->userRepository->findByCorreo($data['correo']);
            if ($existing !== null && $existing->getId() !== $id) {
                return $this->json(['error' => 'El correo ya está registrado.'], Response::HTTP_CONFLICT);
            }
            $user->setCorreo($data['correo']);
        }

        if (isset($data['nombre'])) {
            $user->setNombre($data['nombre']);
        }
        if (isset($data['apellido'])) {
            $user->setApellido($data['apellido']);
        }
        if (isset($data['contrasena'])) {
            $user->setContrasena(password_hash($data['contrasena'], PASSWORD_BCRYPT));
        }

        $this->userRepository->save($user);
        return $this->json($user->toArray());
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        if (!$this->userRepository->delete($id)) {
            return $this->json(['error' => 'Usuario no encontrado.'], Response::HTTP_NOT_FOUND);
        }
        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
