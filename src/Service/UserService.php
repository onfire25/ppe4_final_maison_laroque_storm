<?php
// src/Service/UserService.php
namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService
{
    protected $em;
    protected $repository;
    protected $passwordEncoder;

    /**
     * UserService constructor.
     *
     * @param EntityManagerInterface $em by dependency injection
     */
    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository(User::class);
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * Set a password encoded to a user
     *
     * @param User $user
     * @param String $passwordInCLear
     */
    public function encodePassword(User $user)
    {
        $plainPassword = $user->getPlainPassword();

        if (!empty($plainPassword))
        {
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                $plainPassword
            ));
        }

        return $user;
    }


    /**
     * Delete a user object in bdd
     *
     * @param User $user
     */
    public function delete(User $user)
    {
        $this->em->remove($user);
        $this->em->flush();
    }


    /**
     * Save a user object in bdd
     *
     * @param User $user
     */
    public function save(User $user)
    {
        $user = $this->encodePassword($user);
        $this->em->persist($user);
        $this->em->flush();
    }
}
