<?php

namespace App\Swagger\Schemas;

/**
 * @OA\Schema(
 *     schema="AuthorCreateRequest",
 *     required={"nome"},
 *     title="Author Create Request",
 *     description="Dados necessários para criar um autor",
 *     @OA\Property(
 *         property="nome",
 *         type="string",
 *         maxLength=40,
 *         example="Cecília Meireles"
 *     )
 * )
 */
class AuthorCreateSchema {}
