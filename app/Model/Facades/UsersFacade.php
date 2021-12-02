<?php

namespace App\Model\Facades;

use App\Model\Authorizator\AuthenticatedRole;
use App\Model\Entities\Role;
use App\Model\Entities\User;
use App\Model\Repositories\ForgottenPasswordRepository;
use App\Model\Repositories\PermissionRepository;
use App\Model\Repositories\ResourceRepository;
use App\Model\Repositories\RoleRepository;
use App\Model\Repositories\UserRepository;
use Exception;
use Nette\Security\SimpleIdentity;
use Tracy\Debugger;

class UsersFacade
{
    private UserRepository $userRepository;

    private ForgottenPasswordRepository $forgottenPasswordRepository;

    private ResourceRepository $resourceRepository;

    private RoleRepository $roleRepository;

    private PermissionRepository $permissionRepository;

    public function __construct(
        UserRepository $userRepository,
        ForgottenPasswordRepository $forgottenPasswordRepository,
        ResourceRepository $resourceRepository,
        RoleRepository $roleRepository,
        PermissionRepository $permissionRepository,
    ) {
        $this->userRepository = $userRepository;
        $this->forgottenPasswordRepository = $forgottenPasswordRepository;
        $this->resourceRepository = $resourceRepository;
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }

    public function getUser(int $id): User
    {
        return $this->userRepository->find($id);
    }

    public function getUserByEmail(string $email): User
    {
        return $this->userRepository->findBy(['email' => $email]);
    }

    public function saveUser(User $user)
    {
        return (bool)$this->userRepository->persist($user);
    }

    public function getUserIdentity(User $user): SimpleIdentity
    {
        $roles = [];

        $roles[] = new AuthenticatedRole($user->id);

        if (!empty($user->role)) {
            $roles[] = $user->role->id;
        }

        return new SimpleIdentity($user->id, $roles, ['name' => $user->name, 'email' => $user->email]);
    }

    public function deleteForgottenPasswordsByUser($user)
    {
        try {
            if ($user instanceof User) {
                $user = $user->id;
            }

            $this->forgottenPasswordRepository->delete(['user_id' => $user]);
        } catch (Exception $e) {
            Debugger::log($e);
        }
    }

    /**
     * @return Resource[]
     */
    public function findResources(): array
    {
        return $this->resourceRepository->findAll();
    }

    /**
     * @return Role
     */
    public function findRole(string $id): Role
    {
        return $this->roleRepository->find($id);
    }

    /**
     * @return Role[]
     */
    public function findRoles(): array
    {
        return $this->roleRepository->findAll();
    }

    /**
     * @return Permission[]
     */
    public function findPermissions(): array
    {
        return $this->permissionRepository->findAll();
    }
}
