<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\AuthorCreationException;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorRequest;
use App\Http\Resources\AuthorResource;
use App\Services\AuthorService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthorController extends Controller
{

    use ApiResponse;

    public function __construct(protected AuthorService $service) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * @OA\Post(
     *     path="/api/authors",
     *     summary="Cria um novo autor",
     *     tags={"Authors"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/AuthorCreateRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Autor criado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Autor criado com sucesso"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="nome", type="string", example="Cecília Meireles")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro interno"
     *     )
     * )
     */

    public function store(AuthorRequest $request)
    {
        try {
            $author = $this->service->store($request->validated());
            return $this->success(new AuthorResource($author), 'Autor criado com sucesso', 201);
        } catch (AuthorCreationException $e) {
            return $this->error($e->getMessage(), 400);
        } catch (\Throwable $e) {
            Log::error('Erro inesperado ao criar autor', ['exception' => $e]);
            return $this->error('Erro interno ao criar autor', 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
