<?php

declare(strict_types=1);

namespace App\Entity;

class User
{
    private int $id;
    private string $nombre;
    private string $apellido;
    private string $correo;
    private string $contrasena;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function getApellido(): string
    {
        return $this->apellido;
    }

    public function setApellido(string $apellido): void
    {
        $this->apellido = $apellido;
    }

    public function getCorreo(): string
    {
        return $this->correo;
    }

    public function setCorreo(string $correo): void
    {
        $this->correo = $correo;
    }

    public function getContrasena(): string
    {
        return $this->contrasena;
    }

    public function setContrasena(string $contrasena): void
    {
        $this->contrasena = $contrasena;
    }

    public function toArray(): array
    {
        return [
            'id'       => $this->id,
            'nombre'   => $this->nombre,
            'apellido' => $this->apellido,
            'correo'   => $this->correo,
            // contraseña no se expone ✔
        ];
    }
}