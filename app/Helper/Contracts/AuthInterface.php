<?php

namespace App\Helper\Contracts;

interface AuthInterface
{
    /**
     * Return the authenticated user.
     * 
     * @return mixed
     */
    public function user();

    /**
     * Return merchant uuid of authenticated user.
     * 
     * @return mixed
     */
    public function merchantUuid();

    /**
     * Return uuid of authenticated user.
     * 
     * @return mixed
     */
    public function userUuid();

    /**
     * Return user type of authenticated user.
     * 
     * @return mixed
     */
    public function userType();

    /**
     * Merge the authenticated user to form request.
     * 
     * @return Illuminate\Http\Request
     */
    public function merge();
}
