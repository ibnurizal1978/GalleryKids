<?php

namespace App\Http\Controllers;

use App\Http\Requests\GEMembershipUpgradeRequest;
use App\Http\Requests\StoreKidsRequest;
use App\Http\Requests\UpdateProfileInfoRequest;
use App\Repositories\MembersonRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class MembersonController extends Controller
{
    /**
     * @var MembersonRepository
     */
    protected $repository;

    public function __construct( MembersonRepository $repository )
    {
        $this->repository = $repository;
    }

    public function upgradeGalleryExplorerMembership( GEMembershipUpgradeRequest $request )
    {
        $this->repository->upgradeGEMembership( $request );

        return response( [
            'message' => 'success'
        ] );
    }

    public function addKids( StoreKidsRequest $request )
    {
        $success = $this->repository->addKids( $request );
        $this->repository->addGPEBenefit();

        return response(
            [
                'message' => $success ? 'Children added' : "Couldn't added children"
            ],
            $success ? SymfonyResponse::HTTP_OK : SymfonyResponse::HTTP_BAD_REQUEST
        );
    }

    public function updateProfile( UpdateProfileInfoRequest $request )
    {
        $success = $this->repository->updateMissingProfile( $request );

        return response(
            [
                'message' => $success ? 'Profile Info Updated' : "Couldn't update profile info"
            ],
            $success ? SymfonyResponse::HTTP_OK : SymfonyResponse::HTTP_BAD_REQUEST
        );
    }
}
