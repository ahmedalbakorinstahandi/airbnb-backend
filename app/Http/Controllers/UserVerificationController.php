<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserVerification\CreateRequest;
use App\Http\Requests\UserVerification\UpdateRequest;
use App\Http\Resources\UserVerificationResource;
use App\Http\Services\UserVerificationService;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use App\Http\Permissions\UserVerificationPermission;

class UserVerificationController extends Controller
{

    protected $userVerificationService;

    public function __construct(UserVerificationService $userVerificationService)
    {
        $this->userVerificationService = $userVerificationService;
    }


    public function index()
    {
        $userVerifications = $this->userVerificationService->index(request()->all());

        return ResponseService::response([
            'success' => true,
            'data' => $userVerifications,
            'resource' => UserVerificationResource::class,
            'status' => 200,
            'meta' => true,
        ]);
    }

    public function show(string $id)
    {
        $userVerification = $this->userVerificationService->show($id);

        UserVerificationPermission::show($userVerification);

        return ResponseService::response([
            'success' => true,
            'data' => $userVerification,
            'resource' => UserVerificationResource::class,
            'status' => 200,
        ]);
    }


    public function create(CreateRequest $request)
    {

        $data = $request->validated();

        $data = UserVerificationPermission::create($data);

        $userVerification = $this->userVerificationService->create($data);

        return ResponseService::response([
            'success' => true,
            'message' => 'messages.user_verification.create',
            'resource' => UserVerificationResource::class,
            'data' => $userVerification,
        ]);
    }



    public function update(UpdateRequest $request, string $id)
    {
        $userVerification = $this->userVerificationService->show($id);

        UserVerificationPermission::canUpdate($userVerification);

        $userVerification = $this->userVerificationService->update($userVerification, $request->validated());

        return ResponseService::response([
            'success' => true,
            'message' => 'messages.user_verification.update',
            'resource' => UserVerificationResource::class,
            'data' => $userVerification,
        ]);
    }


    public function destroy(string $id)
    {
        $userVerification = $this->userVerificationService->show($id);

        UserVerificationPermission::canDelete($userVerification);

        $this->userVerificationService->destroy($userVerification);

        return ResponseService::response([
            'success' => true,
            'message' => 'messages.user_verification.destroy',
            'status' => 200,
        ]);
    }
}
