<?php
namespace App\Security;
/**
 * Class PostVoter
 * User: Nessandro
 * Date: 2019-05-18
 * Time: 16:29
 */

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class CommentVoter extends Voter
{
    const IS_EDITABLE   = 'editable';
    const IS_DELETABLE  = 'deletable';

    /**
     * Determines if the attribute and subject are supported by this voter.
     *
     * @param string $attribute An attribute
     * @param mixed $subject The subject to secure, e.g. an object the user wants to access or any other PHP type
     *
     * @return bool True if the attribute and subject are supported, false otherwise
     */
    protected function supports($attribute, $subject)
    {
        if (!$subject instanceof Comment) {
            return false;
        }

        if (!in_array($attribute, [self::IS_EDITABLE, self::IS_DELETABLE])) {
            return false;
        }

        return true;
    }

    /**
     * Perform a single access check operation on a given attribute, subject and token.
     * It is safe to assume that $attribute and $subject already passed the "supports()" method check.
     *
     * @param string $attribute
     * @param mixed $subject
     * @param TokenInterface $token
     *
     * @return bool
     */
    protected function voteOnAttribute($attribute, $comment, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User)
        {
            return false;
        }

        return $comment->getUser()->getId() === $user->getId();

    }
}