<?php

namespace App\Security\Voter;

use App\Entity\Product;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ProductVoter extends Voter
{
    public const EDIT = 'PRODUCT_EDIT';
    public const DELETE = 'PRODUCT_DELETE';

    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::EDIT, self::DELETE])
            && $subject instanceof Product;
    }

    protected function voteOnAttribute(string $attribute, mixed $product, TokenInterface $token): bool
    {
        // Exemple : si tu veux autoriser les admins
        if ($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }

        return match ($attribute) {
            self::EDIT => $this->canEdit($product),
            self::DELETE => $this->canDelete($product),
            default => false,
        };
    }

    private function canEdit(Product $product): bool
    {
        // Exemple : autoriser si le produit coûte moins de 100€
        return $product->getPrice() < 100;
    }

    private function canDelete(Product $product): bool
    {
        // Exemple : autoriser si le produit n’a pas d’images
        return count($product->getImages()) === 0;
    }
}
